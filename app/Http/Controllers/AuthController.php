<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Detection\MobileDetect;

/**
 * AuthController
 * 
 * Handles authentication logic, replacing the legacy verif.php script.
 */
class AuthController extends Controller
{
    /**
     * Show the verification/login page.
     *
     * @return \Illuminate\View\View
     */
    public function showVerif()
    {
        return view('auth.verif');
    }

    /**
     * Handle login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate inputs
        $request->validate([
            'nom' => 'required|string',
            'pas' => 'required|string',
        ]);

        $nom = trim($request->input('nom'));
        $pas = trim($request->input('pas'));

        // Get IP and user agent for logging
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        // Query user from wx25_usu table
        $user = DB::table('wx25_usu')
            ->where('nickz', $nom)
            ->where('estado', 0)
            ->first();

        if (!$user) {
            // Log failed attempt - avoid logging full username for security
            error_log("Login failed - User hash: " . substr(md5($nom), 0, 8) . ", IP: {$ip}");
            return redirect('/log_fail.html');
        }

        // Check password - use hashed password if available, otherwise use plaintext pazz
        $passwordValid = false;
        
        if (!empty($user->password)) {
            // Use hashed password
            $passwordValid = Hash::check($pas, $user->password);
        } else {
            // Fallback to plaintext pazz (legacy)
            $passwordValid = ($pas === $user->pazz);
        }

        if (!$passwordValid) {
            // Log failed attempt - avoid logging full username for security
            error_log("Login failed - Invalid password, User hash: " . substr(md5($nom), 0, 8) . ", IP: {$ip}");
            return redirect('/log_fail.html');
        }

        // Get organization data
        $organizacion = DB::table('trn25_organizacion')
            ->where('id', $user->id_asocc)
            ->first();

        if (!$organizacion) {
            // Log failed attempt - avoid logging full username for security
            error_log("Login failed - Organization not found, User hash: " . substr(md5($nom), 0, 8));
            return redirect('/log_fail.html');
        }

        // Regenerate session for security
        $request->session()->regenerate();

        // Set session variables (equivalent to verif.php)
        $request->session()->put([
            'nombre_usu' => $organizacion->nombre,
            'id_usuario' => $user->id_asocc,
            'img_foto' => $organizacion->escudo,
            'tipo_U' => $user->tipoU,
            'idUxer' => $user->id,
            'inicio_sesion' => time(),
            'ultimo_acceso' => time(),
            'ip_origen' => $ip,
            'user_agent' => $userAgent,
            // Note: Laravel provides its own CSRF token via csrf_token() helper
            // This custom token is kept for compatibility with legacy code
            'token_csrf' => csrf_token(),
        ]);

        // Log successful login
        error_log("Login successful - User: {$nom}, IP: {$ip}, Club: {$organizacion->nombre}");

        // Detect mobile device
        $detect = new MobileDetect();

        // Redirect based on device type and user type
        if ($detect->isMobile()) {
            // Mobile redirection
            if ($user->tipoU == 1) {
                $request->session()->put('direction', 'indexApp.php');
                return redirect('/dam/movil');
            } else {
                return redirect('/movil_fail.html');
            }
        } else {
            // Desktop redirection
            if ($user->tipoU == 1) {
                $request->session()->put('direction', 'club.php');
                return redirect('/dam/desk');
            } else {
                return redirect('/log_fail.html');
            }
        }
    }

    /**
     * Handle logout request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Flush all session data
        $request->session()->flush();

        // Redirect to home
        return redirect('/');
    }
}
