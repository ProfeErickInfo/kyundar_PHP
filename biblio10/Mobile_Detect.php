<?php
/**
 * Mobile Detect Library - Simplified version for Kyundar
 * Based on Mobile_Detect original by Serban Ghita
 * 
 * Detects mobile devices (including tablets)
 */

class Mobile_Detect
{
    /**
     * Mobile detection rules.
     */
    protected static $phoneDevices = array(
        'iPhone'        => '\biPhone.*Mobile|\biPod',
        'BlackBerry'    => 'BlackBerry|\bBB10\b|rim[0-9]+',
        'HTC'           => 'HTC|HTC.*(Sensation|Evo|Vision|Explorer|6800|8100|8900|A7272|S510e|C110e|Legend|Desire|T8282)|APX515CKT|Qtek9090|APA9292KT|HD_mini|Sensation.*Z710e|PG86100|Z715e|Desire.*(A8181|A9192|S510e)|ADR6200|ADR6400L|ADR6425|001HT|Inspire.4G|Android.*\bEVO\b|T-Mobile.G1|Z520m',
        'Nexus'         => 'Nexus\s*One|Nexus\s*S|Galaxy.*Nexus|Android.*Nexus.*Mobile',
        'Dell'          => 'Dell.*Streak|Dell.*Aero|Dell.*Venue|DELL.*Venue\sPro|Dell\sFlash|Dell\sSmoke|Dell\sMini\s3iX|XCD28|XCD35|\b001DL\b|\b101DL\b|\bGS01\b',
        'Motorola'      => 'Motorola|DROIDX|DROID\sBIANIC|TBL|A1000|A1200|A555|A955|A956|Motorola.*Mobile|MOTOROLA.*Mobile',
        'Samsung'       => 'Samsung|SGH|SCH|SHW|SPH|GT|SM|Galaxy.*Mobile|SAMSUNG.*Mobile|Android.*SCH-I[0-9]+|Galaxy.*Nexus|GT-I9[0-9]+|GT-I8[0-9]+|GT-P1000|GT-P1010|GT-P7100|GT-P7300|GT-P7310|GT-P7500|GT-P7510|SCH-I[0-9]+|SPH-L900|SPH-M[0-9]+|SPH-P[0-9]+',
        'Sony'          => 'SonyST|SonyLT|SonyEricsson|Android.*XPERIA|Android.*Sony.*Mobile|SGPT|SonyTablet',
        'Asus'          => 'Asus.*Galaxy|PadFone.*Mobile',
        'Palm'          => 'PalmSource|Palm', // avantgo|blazer|elaine|hiptop|plucker|xiino ; @todo - complete the regex.
        'Vertu'         => 'Vertu|Vertu.*Ltd|Vertu.*Ascent|Vertu.*Ayxta|Vertu.*Constellation(F|Quest)?|Vertu.*Monika|Vertu.*Signature', // Just for fun ;)
        // @todo: Include more explicit tablet rules.
        'GenericPhone'  => 'Smartphone|iphone|ipad|ipod|S60|PPC|Pocket|Mobile|BlackBerry|Wap'
    );

    /**
     * List of tablet devices.
     */
    protected static $tabletDevices = array(
        'iPad'              => 'iPad|iPad.*Mobile', // @todo: check for mobile friendly emails topic.
        'NexusTablet'       => 'Android.*Nexus[\s]+(7|9|10)',
        'SamsungTablet'     => 'SAMSUNG.*Tablet|Galaxy.*Tab|SCH-I800|GT-P1000|GT-P1003|GT-P1010|GT-P3105|GT-P6210|GT-P6800|GT-P6810|GT-P7100|GT-P7300|GT-P7310|GT-P7500|GT-P7510|SGH-T849|SGH-i957|SGH-i987|SPH-P100|GT-P3100|GT-P3108|GT-P3110|GT-P5100|GT-P5110|GT-P6200|GT-P7320|GT-P7511|GT-N8000|GT-P8510|SGH-i467|GT-P7500|GT-N8010|GT-N8020|GT-P1013|GT-P6201|GT-P7501|GT-N5100|GT-N5105|GT-N5110|SHV-E140K|SHV-E140L|SHV-E140S|SHV-E150S|SHV-E230K|SHV-E230L|SHV-E230S|SHW-M180K|SHW-M180L|SHW-M180S|SHW-M180W|SHW-M300W|SHW-M305W|SHW-M380K|SHW-M380S|SHW-M380W|SHW-M430W|SHW-M480K|SHW-M480S|SHW-M480W|SHW-M485W|SHW-M486W|SHW-M500W|GT-I9228|SCH-P739|SCH-I925|GT-I9200|GT-P5200|GT-P5210|GT-P5210X|SM-T311|SM-T310|SM-T310X|SM-T210|SM-T210R|SM-T211|SM-P600|SM-P601|SM-P605|SM-P900|SM-P901|SM-T217|SM-T217A|SM-T217S|SM-P6000|SM-T3100|SGH-I467|XE500|SM-T110|GT-P5220|GT-I9200X|GT-N5110X|GT-N5120|SM-P905|SM-T111|SM-T2105|SM-T315|SM-T320|SM-T320X|SM-T321|SM-T520|SM-T525|SM-T530NU|SM-T230NU|SM-T330NU|SM-T900|XE500T1C|SM-P605V|SM-P905V|SM-T337V|SM-T537V|SM-T707V|SM-T807V|SM-P600X|SM-P900X|SM-T210X|SM-T230|SM-T230X|SM-T325|GT-P7503|SM-T531|SM-T330|SM-T530|SM-T705C|SM-T535|SM-T331|SM-T800|SM-T700|SM-T537|SM-T807|SM-P907A|SM-T337A|SM-T537A|SM-T707A|SM-T807A|SM-T237|SM-T807P|SM-P607T|SM-T217T|SM-T337T|SM-T807T|SM-T116NQ|SM-P550|SM-T350|SM-T550|SM-T9000|SM-P9000|SM-T705|SM-T805|GT-P3113|SM-T710|SM-T810|SM-T815|SM-T360|SM-T533|SM-T113|SM-T335|SM-T715|SM-T560|SM-T670|SM-T677|SM-T377|SM-T567|SM-T357T|SM-T555|SM-T561|SM-T713|SM-T719|SM-T813|SM-T819|SM-T290|SM-T295|SM-T510|SM-T515|SM-T387|SM-P205|SM-T307|SM-T307U|SM-T575|SM-P610|SM-P615|SM-T870|SM-T875|SM-P900|SM-P905|SM-T531',
        'Kindle'            => 'Kindle|Silk.*Accelerated|Android.*\b(KFOT|KFTT|KFJWI|KFJWA|KFOTE|KFSOWI|KFTHWI|KFTHWA|KFAPWI|KFAPWA|WFJWAE|KFSAWA|KFSAWI|KFASWI|KFARWI|KFFOWI|KFGIWI|KFMEWI)\b|Android.*Silk/[0-9.]+ like Chrome/[0-9.]+ (?!Mobile)',
        'SurfaceTablet'     => 'Windows NT [0-9.]+; ARM|^.*Windows.*ARM.*Tablet.*$',
        'HPTablet'          => 'HP Slate|HP ElitePad|hpwOS|\b(TouchPad|webOS)\b|HP Touchpad|PlayBook|BB10',
        'AsusTablet'        => '^.*PadFone((?!Mobile).)*$|Transformer|TF101|TF101G|TF300T|TF300TG|TF300TL|TF700T|TF700KL|TF701T|TF810C|ME171|ME301T|ME302C|ME371MG|ME370T|ME372MG|ME172V|ME173X|ME400C|Slider SL101|\bK00F\b|\bK00C\b|\bK00E\b|\bK00L\b|TX201LA|ME176C|ME102A|\bM80TA\b|ME372CL|ME560CG|ME372CG|ME302KL| K010 | K011 | K017 | K01E |ME572C|ME103K|ME170C|ME171C|\bME70C\b|ME581C|ME581CL|ME8510C|ME181C|P01Y|PO1MA|P01Z|\bP027\b|\bP024\b|\bP00C\b',
        'BlackBerryTablet'  => 'PlayBook|RIM Tablet',
        'HTCTablet'         => 'HTC_Flyer_P512|HTC Flyer|HTC Jetstream|HTC-P715a|HTC EVO View 4G|PG41200|PG09410',
        'MotorolaTablet'    => 'xoom|sholest|MZ615|MZ605|MZ505|MZ601|MZ602|MZ603|MZ604|MZ606|MZ607|MZ608|MZ609|MZ615|MZ616|MZ617',
        'NookTablet'        => 'Android.*Nook|NookColor|nook browser|BNRV200|BNRV200A|BNTV250|BNTV250A|BNTV400|BNTV600|LogicPD Zoom2',
        'AcerTablet'        => 'Android.*; \b(A100|A101|A110|A200|A210|A211|A500|A501|A510|A511|A700|A701|W500|W500P|W501|W501P|W510|W511|W700|G100|G100W|B1-A71|B1-710|B1-711|A1-810|A1-811|A1-830)\b|W3-810|\bA3-A10\b|\bA3-A11\b|\bA3-A20\b|\bA3-A30',
        'ToshibaTablet'     => 'Android.*(AT100|AT105|AT200|AT205|AT270|AT275|AT300|AT305|AT1S5|AT500|AT570|AT700|AT830)|TOSHIBA.*FOLIO',
        'LGTablet'          => '\bL-06C|LG-V909|LG-V900|LG-V700|LG-V510|LG-V500|LG-V410|LG-V400|LG-VK810\b',
        'FuchsiaTablet'     => 'Android.*\b(Ideatab|YOGA|YOGA\s*Tablet|Lenovo\s*A10-70F|A7-10F|TB-X103F|TB-X304[FL]|TB-8703[FNX]|TB-7304[FINX]|TB-8504[FX]|TB-X605[FL]|TB-X505[FL]|TB-X705[FL]|YT3-X90[FL]|TB3-X70[FL]|TB-X103F|TB2-X30L|PB2-670Y|PB1-770M|MT8735|MT8121|MT8389)\b',
        'MicrosoftTablet'   => 'Windows.*ARM.*Tablet',
        'UCTablet'          => 'UC.*Browser.*Tablet',
        'AndroidTablet'     => 'Android[^;]*;[^;]*(?:(?!Mobile)[^;])*;[^;]*\b(?:Build\b|\))',
        'GenericTablet'     => 'tablet|android|Tablet|TABLET'
    );

    /**
     * Operating systems.
     */
    protected static $operatingSystems = array(
        'AndroidOS'         => 'Android',
        'BlackBerryOS'      => 'blackberry|rim\stablet\sos',
        'PalmOS'            => 'PalmOS|avantgo|blazer|elaine|hiptop|palm|plucker|xiino',
        'SymbianOS'         => 'Symbian|SymbOS|Series60|Series40|SYB-[0-9]+|\bS60\b',
        'WindowsMobileOS'   => 'Windows\sCE.*(PPC|Smartphone|Mobile|[0-9]{3}x[0-9]{3})|Window\sMobile|Windows\sPhone\s[0-9.]+|WCE;',
        'WindowsPhoneOS'    => 'Windows\sPhone\s[0-9.]+',
        'iOS'               => '\biPhone.*OS\s([0-9\.]+)|\biPad.*OS\s([0-9\.]+)|\biPod.*OS\s([0-9\.]+)|iPhone\sOS|iOS'
    );

    /**
     * Class constructor.
     */
    public function __construct()
    {
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            $_SERVER['HTTP_USER_AGENT'] = null;
        }
    }

    /**
     * Magic overloading method.
     *
     * @method boolean is[...]()
     * @param  string $name
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (substr($name, 0, 2) !== 'is') {
            throw new BadMethodCallException("No such method exists: $name.");
        }

        $this->setDetectionType(self::DETECTION_TYPE_MOBILE);

        $key = substr($name, 2);

        return $this->matchUAAgainstKey($key);
    }

    /**
     * Retrieve the mobile grading, A, B, C or the default grade.
     *
     * @return string
     */
    public function mobileGrade()
    {
        $isMobile = $this->isMobile();
        if (
            // Apple iOS 3.2-5.1 - Tested on the original iPad (4.3 / 5.0), iPad 2 (4.3), iPad 3 (5.1), original iPhone (3.1), iPhone 3 (3.2), 3GS (4.3), 4 (4.3 / 5.0), and 4S (5.1)
            $this->version('iPad', self::VERSION_TYPE_FLOAT) >= 4.3 ||
            $this->version('iPhone', self::VERSION_TYPE_FLOAT) >= 3.1 ||
            $this->version('iPod', self::VERSION_TYPE_FLOAT) >= 3.1 ||

            // Android 2.1+ - Tested on the HTC Incredible (2.2), original Droid (2.2), HTC Aria (2.1), Google Nexus S (2.3). Functional on 1.5 & 1.6 but performance may be sluggish, tested on Google G1 (1.5)
            // Android 3.1 (Honeycomb)  - Tested on the Samsung Galaxy Tab 10.1 and Motorola XOOM
            // Android 4.0 (ICS)  - Tested on a Galaxy Nexus. Note: transition performance can be poor on upgraded devices
            // Android 4.1 (Jelly Bean)  - Tested on a Galaxy Nexus and Galaxy 7
            ($this->version('Android', self::VERSION_TYPE_FLOAT) > 2.1 && $this->is('Webkit')) ||

            // Windows Phone 7.5-8 - Tested on the HTC Surround (7.5), HTC Trophy (7.5), LG-E900 (7.5), Nokia Lumia 800 (7.8) and Nokia Lumia 520 (8.0).
            $this->version('Windows Phone OS', self::VERSION_TYPE_FLOAT) >= 7.5 ||

            // Blackberry 7 - Tested on BlackBerry® Torch 9810
            // Blackberry 6.0 - Tested on the Blackberry® Curve 9300, BlackBerry® Torch 9810
            // Blackberry 10 - Tested on BlackBerry® Q10 and Z30
            $this->is('BlackBerry') && $this->version('BlackBerry', self::VERSION_TYPE_FLOAT) >= 6.0 ||
            // Blackberry Playbook (1.0-2.1) - Tested on PlayBook
            $this->match('Playbook.*Tablet')

        ) {
            return 'A';
        }

        if (
            $this->is('iOS') && $this->version('iPad', self::VERSION_TYPE_FLOAT) < 4.3 ||
            $this->is('iOS') && $this->version('iPhone', self::VERSION_TYPE_FLOAT) < 3.1 ||
            $this->is('iOS') && $this->version('iPod', self::VERSION_TYPE_FLOAT) < 3.1 ||

            // Blackberry 5.0: Tested on the Blackberry® Curve 8330
            $this->is('Blackberry') && $this->version('BlackBerry', self::VERSION_TYPE_FLOAT) >= 5 && $this->version('BlackBerry', self::VERSION_TYPE_FLOAT) < 6 ||

            //Opera Mini (5.0-6.5) - Tested on the HTC Aria, T-Mobile myTouch, HTC HD2, HTC Inspire, Motorola Droid Pro, HTC Inspire, BB 8550, Nokia E71, HTC Inspire
            ($this->version('Opera Mini', self::VERSION_TYPE_FLOAT) >= 5.0 && $this->version('Opera Mini', self::VERSION_TYPE_FLOAT) <= 6.5 &&
                ($this->version('Android', self::VERSION_TYPE_FLOAT) >= 2.1 || $this->is('iOS') || $this->is('WindowsMobileOS'))) ||

            // Nokia Symbian^3 - Tested on Nokia N8 (Symbian^3), C7 (Symbian^3), also works on N97 (Symbian^1)
            $this->match('NokiaN8|NokiaC7|N97.*Series60|Symbian/3') ||

            // @todo: report this (tested on Nokia N71)
            $this->version('Opera Mobi', self::VERSION_TYPE_FLOAT) >= 11 &&
            $this->is('SymbianOS')
        ) {
            return 'B';
        }

        if (
            // Blackberry 4.x - Tested on the Blackberry® Curve 8330
            $this->version('BlackBerry', self::VERSION_TYPE_FLOAT) <= 5.0 ||
            // Windows Mobile - Tested on the HTC Ozone 7.0
            $this->match('MSIEMobile|Windows CE.*Mobile') ||
            $this->version('Windows Mobile', self::VERSION_TYPE_FLOAT) <= 5.2

        ) {
            return 'C';
        }

        //All older smartphone platforms and featurephones - Any device that doesn't support media queries
        //will receive the basic, C grade experience.
        return 'C';
    }

    /**
     * The version number according to the following code.
     */
    const VERSION_TYPE_STRING = 'text';

    const VERSION_TYPE_FLOAT = 'float';

    /**
     * The detection type according to the following code.
     */
    const DETECTION_TYPE_MOBILE = 'mobile';

    const DETECTION_TYPE_EXTENDED = 'extended';

    /**
     * The current detection type.
     */
    protected $detectionType = self::DETECTION_TYPE_MOBILE;

    /**
     * HTTP user agent.
     *
     * @deprecated
     * @var string
     */
    protected $userAgent = null;

    /**
     * All possible HTTP headers that represent the
     * User-Agent string.
     *
     * @var array
     */
    protected $httpHeaders = array(
        // The default User-Agent string.
        'HTTP_USER_AGENT',
        // Header can occur on devices using Opera Mini.
        'HTTP_X_OPERAMINI_PHONE_UA',
        // Vodafone specific header: http://www.seoprinciple.com/mobile-web-community-still-angry-at-vodafone/24/
        'HTTP_X_DEVICE_USER_AGENT',
        'HTTP_X_ORIGINAL_USER_AGENT',
        'HTTP_X_SKYFIRE_PHONE',
        'HTTP_X_BOLT_PHONE_UA',
        'HTTP_DEVICE_STOCK_UA',
        'HTTP_X_UCBROWSER_DEVICE_UA'
    );

    /**
     * The matching Regex.
     * This is good for debug.
     *
     * @var string
     */
    protected $matchingRegex = null;

    /**
     * The matches that were found.
     * This is good for debug.
     *
     * @var array
     */
    protected $matchesArray = null;

    /**
     * The cache.
     *
     * @var array
     */
    protected $cache = array();

    /**
     * Get the current cache.
     *
     * @return array
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * Get the cache key search the regex.
     *
     * @param  string $regex
     * @return string|false
     */
    protected function getCacheKey($regex)
    {
        return array_search(md5($regex), $this->cache);
    }

    /**
     * Find a detection rule that matches the current User-agent.
     *
     * @param  null    $userAgent deprecated
     * @return boolean
     */
    public function isMobile($userAgent = null)
    {
        if ($userAgent) {
            trigger_error("The parameter \$userAgent is deprecated, the functionality is preserved", E_USER_DEPRECATED);
        }

        $this->setDetectionType(self::DETECTION_TYPE_MOBILE);

        if ($this->checkHttpHeadersForMobile()) {
            return true;
        } else {
            return $this->matchDetectionRulesAgainstUA();
        }

    }

    /**
     * Find a detection rule that matches the current User-agent.
     *
     * @param  null    $userAgent deprecated
     * @return boolean
     */
    public function isTablet($userAgent = null)
    {
        if ($userAgent) {
            trigger_error("The parameter \$userAgent is deprecated, the functionality is preserved", E_USER_DEPRECATED);
        }

        $this->setDetectionType(self::DETECTION_TYPE_EXTENDED);

        return $this->matchDetectionRulesAgainstUA();
    }

    /**
     * Retrieves the User-Agent.
     *
     * @param  null        $userAgent deprecated
     * @return string|null
     */
    public function getUserAgent($userAgent = null)
    {
        if ($userAgent) {
            trigger_error("The parameter \$userAgent is deprecated, the functionality is preserved", E_USER_DEPRECATED);
        }

        return $this->getHttpHeader('HTTP_USER_AGENT');
    }

    /**
     * Retrieves a particular header. If it doesn't exist, no exception/error is caused.
     * Simply null is returned.
     *
     * @param  string     $header The name of the header to retrieve. Can be HTTP compliant such as
     *                            "User-Agent" or "X-Device-User-Agent" or can be php-esque with the
     *                            all-caps, HTTP_ prefixed, underscore separated awesomeness.
     * @return string|null The value of the header.
     */
    public function getHttpHeader($header)
    {
        // are we using PHP-flavored headers?
        if (strpos($header, '_') !== false) {
            $header = strtoupper($header);
        } else {
            // Otherwise, we'll standardize on the HTTP header.
            $header = strtoupper(str_replace('-', '_', $header));
            if (strpos($header, 'HTTP_') !== 0) {
                $header = 'HTTP_' . $header;
            }
        }

        // Test the alternate, too
        $altHeader = null;
        if ($header === 'HTTP_USER_AGENT') {
            $altHeader = 'HTTP_X_OPERAMINI_PHONE_UA';
        }

        if (!empty($_SERVER[$header])) {
            return $_SERVER[$header];
        } elseif (!empty($_SERVER[$altHeader])) {
            return $_SERVER[$altHeader];
        }

        return null;
    }

    /**
     * Get mobile headers.
     *
     * @return array
     */
    public function getMobileHeaders()
    {
        return self::$mobileHeaders;
    }

    /**
     * Get user agent headers.
     *
     * @return array
     */
    public function getUaHttpHeaders()
    {
        return $this->httpHeaders;
    }

    /**
     * Set the Http headers.
     *
     * @param array $httpHeaders The headers to set. If null, then using PHP's _SERVER to extract
     *                           the headers. The default null is left for backwards compatibility.
     */
    public function setHttpHeaders($httpHeaders = null)
    {
        //use global _SERVER if $httpHeaders aren't defined
        if (!is_array($httpHeaders) || !count($httpHeaders)) {
            $httpHeaders = $_SERVER;
        }

        //clear existing headers
        $this->httpHeaders = array();

        // Only save HTTP headers. In PHP land, that means only _SERVER vars that
        // start with HTTP_.
        foreach ($httpHeaders as $key => $value) {
            if (substr($key, 0, 5) === 'HTTP_') {
                $this->httpHeaders[$key] = $value;
            }
        }
    }

    /**
     * Retrieves the cloudfront headers.
     */
    public function getCfHeaders()
    {
        return self::$cloudFrontUA;
    }

    /**
     * Checks the HTTP headers for signs of mobile.
     * This is the fastest mobile check possible; it's used
     * inside isMobile() for this reason.
     *
     * @return bool
     */
    public function checkHttpHeadersForMobile()
    {

        foreach (self::$mobileHeaders as $mobileHeader => $matchType) {
            $httpHeader = $this->getHttpHeader($mobileHeader);
            if ($httpHeader === null) {
                continue;
            }

            if (is_array($matchType['matches'])) {
                foreach ($matchType['matches'] as $match) {
                    if (strpos($httpHeader, $match) !== false) {
                        return true;
                    }
                }

                return false;
            } else {
                if (strpos($httpHeader, $matchType['matches']) !== false) {
                    return true;
                }
            }
        }

        return false;

    }

    /**
     * Magic overloading method.
     *
     * @method boolean is[...]()
     * @param  string $name
     * @param  array  $arguments
     * @return mixed
     * @throws BadMethodCallException when the method doesn't exist and doesn't start with 'is'
     */
    public function setDetectionType($type = null)
    {

        if ($type === null) {
            $type = self::DETECTION_TYPE_MOBILE;
        }

        if ($type !== self::DETECTION_TYPE_MOBILE && $type !== self::DETECTION_TYPE_EXTENDED) {

            throw new InvalidArgumentException("Wrong detection type provided.");
        }

        $this->detectionType = $type;

        return $this;

    }

    /**
     * Retrieve the list of known phone devices.
     *
     * @param  string $device The name of the device.
     * @return string
     */
    public static function getPhoneDevices()
    {
        return self::$phoneDevices;
    }

    /**
     * Retrieve the list of known tablet devices.
     *
     * @param  string $device The name of the device.
     * @return string
     */
    public static function getTabletDevices()
    {
        return self::$tabletDevices;
    }

    /**
     * Retrieve the list of known operating systems.
     *
     * @return array List of operating systems.
     */
    public static function getOperatingSystems()
    {
        return self::$operatingSystems;
    }

    /**
     * Check the HTTP headers for signs of mobile.
     * This is the fastest mobile check possible; it's used
     * inside isMobile() for this reason.
     *
     * @param  string $key
     * @return boolean
     */
    public function matchUAAgainstKey($key)
    {

        return $this->match($this->getProperties()[$key]);

    }

    /**
     * Check if the device is mobile.
     * Returns true if any type of mobile device detected, including special ones
     * @param  null    $userAgent   deprecated
     * @param  array   $httpHeaders deprecated
     * @return boolean
     */
    protected function matchDetectionRulesAgainstUA($userAgent = null, $httpHeaders = null)
    {

        if ($userAgent) {
            trigger_error("The parameter \$userAgent is deprecated, the functionality is preserved", E_USER_DEPRECATED);
        }

        if ($httpHeaders) {
            trigger_error("The parameter \$httpHeaders is deprecated, the functionality is preserved", E_USER_DEPRECATED);
        }

        $userAgent = $this->getUserAgent();
        if (empty($userAgent)) {
            return false;
        }

        foreach ($this->getProperties() as $regex) {
            if (empty($regex)) { continue; }

            if ($this->match($regex, $userAgent)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the properties array.
     */
    protected function getProperties()
    {

        if ($this->detectionType == self::DETECTION_TYPE_EXTENDED) {
            return array_merge(self::$phoneDevices, self::$tabletDevices, self::$operatingSystems);
        } else {
            return self::$phoneDevices;
        }

    }

    /**
     * Searches for a certain key in the rules array.
     * If the key is found then try to match the corresponding
     * regex against the User-Agent.
     *
     * @param  string $key
     * @return string
     */
    protected function match($regex, $userAgent = null)
    {

        // Escape the special character which is used to delimit the pattern.
        $regex = str_replace('/', '\/', $regex);

        return (bool) preg_match('/'.$regex.'/is', $userAgent ?: $this->getUserAgent(), $matches);
    }

    /**
     * Some detection rules are relative (not standard),
     * because of the diversity of devices, vendors and
     * their conventions in representing the User-Agent or
     * the HTTP headers.
     *
     * This method will be used to check custom regexes against
     * the User-Agent string.
     *
     * @param  string $regex
     * @param  string $userAgent
     * @return bool
     *
     * @todo: search in the HTTP headers too.
     */
    public function matchUserAgent($regex, $userAgent = null)
    {
        return (bool) preg_match('/' . $regex . '/is', $userAgent ?: $this->getUserAgent());
    }

    // following methods are mainly for unitTests

    /**
     * Get the detection rules (regexs).
     *
     * @deprecated
     * @return array
     */
    public function getDetectionRules()
    {
        static $rules;

        if (!$rules) {
            $rules = array_merge(self::$phoneDevices, self::$tabletDevices);
        }

        return $rules;

    }

    /**
     * Get the current detection type.
     *
     * @return string The detection type
     */
    public function getDetectionType()
    {
        return $this->detectionType;
    }

    /**
     * Get the current cache.
     *
     * @param string $key
     * @param string $value
     */
    public function setCache($key, $value = 1)
    {
        $this->cache[md5($key)] = $value;
    }

    /**
     * Retrieve the cache.
     *
     * @param  string $key
     * @return string
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * Get the version number according to the given $propertyName
     *
     * @param string $propertyName
     * @param string $type
     * @return string
     */
    public function version($propertyName, $type = self::VERSION_TYPE_STRING)
    {
        $currentProperty = null;

        foreach ($this->getProperties() as $property => $match) {
            if ($propertyName == $property) {
                $currentProperty = $property;
                break;
            }
        }

        if (is_null($currentProperty)) {
            return false;
        }

        if ($type == self::VERSION_TYPE_FLOAT) {
            return $this->prepareVersionNo($this->getVersion($currentProperty));
        }

        return $this->getVersion($currentProperty);
    }

    /**
     * Prepare the version number.
     *
     * @todo Remove the error supression from str_replace() call.
     *
     * @param string $ver The string version, like "2.6.21.2152";
     *
     * @return float
     */
    protected function prepareVersionNo($ver)
    {
        $ver = str_replace(array('_', ' ', '/'), '.', $ver);
        $arrVer = explode('.', $ver, 2);

        if (isset($arrVer[1])) {
            $arrVer[1] = @str_replace('.', '', $arrVer[1]); // @todo: treat strings versions.
        }

        return (float) implode('.', $arrVer);
    }

    /**
     * Check the version of the given property in the User-Agent.
     * Will return a float number. (eg. 2_0 will return 2.0, 4.3.1 will return 4.31)
     *
     * @param string $propertyName The name of the property. See self::getProperties() array
     *                              keys for all possible properties.
     * @param string $type Either self::VERSION_TYPE_STRING to get a string value or
     *                      self::VERSION_TYPE_FLOAT to get a float value.
     *
     * @return string|float The version of the property we are trying to extract.
     */
    protected function getVersion($propertyName)
    {
        if (empty($propertyName)) { return false; }

        //set the $type to the default if we don't have that
        if (!in_array($propertyName, array_keys($this->getProperties()))) {
            return false;
        }

        // Escape the special character which is used to delimit the pattern
        $properties = $this->getProperties();
        $pattern = str_replace('/', '\/', $properties[$propertyName]);

        preg_match('/'.$pattern.'/is', $this->getUserAgent(), $matches);

        if (empty($matches)) { return false; }

        $version = (count($matches) > 1 ? $matches[array_keys($matches)[1]] : $matches[0]);
        $version = trim($version);

        return $version;
    }

    /**
     * Mobile headers
     *
     * @var array
     */
    protected static $mobileHeaders = array(

            'HTTP_ACCEPT'                  => array('matches' => array(
                                                                        // Opera Mini; @reference: http://dev.opera.com/articles/view/opera-binary-markup-language/
                                                                        'application/x-obml2d',
                                                                        // BlackBerry devices.
                                                                        'application/vnd.rim.html',
                                                                        'text/vnd.wap.wml',
                                                                        'application/vnd.wap.xhtml+xml'
                                                                    )),
            'HTTP_X_WAP_PROFILE'           => array('matches' => null),

            'HTTP_X_WAP_CLIENTID'          => array('matches' => null),

            'HTTP_WAP_CONNECTION'          => array('matches' => null),

            'HTTP_PROFILE'                 => array('matches' => null),
            // Reported by Nokia devices (eg. C3).
            'HTTP_X_OPERAMINI_PHONE_UA'    => array('matches' => null),

            'HTTP_X_NOKIA_IPADDRESS'       => array('matches' => null),

            'HTTP_X_NOKIA_GATEWAY_ID'      => array('matches' => null),

            'HTTP_X_ORANGE_ID'             => array('matches' => null),

            'HTTP_X_VODAFONE_3GPDPCONTEXT' => array('matches' => null),

            'HTTP_X_HUAWEI_USERID'         => array('matches' => null),
            // Reported by Windows Smartphones.
            'HTTP_UA_OS'                   => array('matches' => null),
            // Reported by Verizon, Vodafone proxy system.
            'HTTP_X_MOBILE_GATEWAY'        => array('matches' => null),
            // Seen this on HTC Sensation. @ref: SensationXE_Beats_Z715e
            'HTTP_X_ATT_DEVICEID'          => array('matches' => null),
            // Seen this on a HTC.
            'HTTP_UA_CPU'                  => array('matches' => 'ARM'),
    );

    /**
     * CloudFront User-Agent
     *
     * @var array
     */
    protected static $cloudFrontUA = array(
        'HTTP_CLOUDFRONT_VIEWER_COUNTRY'         => array('matches' => null),
        'HTTP_CLOUDFRONT_IS_TABLET_VIEWER'       => array('matches' => 'true'),
        'HTTP_CLOUDFRONT_IS_MOBILE_VIEWER'       => array('matches' => 'true'),
        'HTTP_CLOUDFRONT_IS_SMARTTV_VIEWER'      => array('matches' => 'true'),
        'HTTP_CLOUDFRONT_IS_DESKTOP_VIEWER'      => array('matches' => 'true')
    );

}