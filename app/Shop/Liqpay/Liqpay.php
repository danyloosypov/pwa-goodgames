<?php
namespace App\Shop\Liqpay;

class Liqpay
{
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_USD = 'USD';
    const CURRENCY_UAH = 'UAH';
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_RUR = 'RUR';

    private $apiUrl = 'https://www.liqpay.ua/api/';
    private $checkoutUrl = 'https://www.liqpay.ua/api/3/checkout';

    protected $supportedCurrencies = array(
        self::CURRENCY_EUR,
        self::CURRENCY_USD,
        self::CURRENCY_UAH,
        self::CURRENCY_RUB,
        self::CURRENCY_RUR,
    );
    
    private $publicKey;
    private $privateKey;
    private $serverResponseCode = null;

    /**
     * Constructor.
     *
     * @param string $public_key
     * @param string $private_key
     * @param string $api_url (optional)
     */
    public function __construct()
    {
        $this->publicKey = env('LIQPAY_PUBLIC_KEY');
        $this->privateKey = env('LIQPAY_PRIVATE_KEY');
    }

    /**
     * Call API
     *
     * @param string $path
     * @param array $params
     * @param int $timeout
     *
     * @return stdClass
     */
    public function api($path, $params = array(), $timeout = 5)
    {
        if (!isset($params['version'])) {
            throw new \InvalidArgumentException('version is null');
        }
        
        $url         = $this->apiUrl . $path;
        $public_key   = $this->publicKey;
        $privateKey  = $this->privateKey;

        $data        = $this->encodeParams(array_merge(compact('public_key'), $params));
        $signature   = $this->strToSign($privateKey.$data.$privateKey);
        $postfields  = http_build_query(array(
            'data'  => $data,
            'signature' => $signature
        ));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,$timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $this->serverResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return json_decode($server_output);
    }

    /**
     * Return last api response http code
     *
     * @return string|null
     */
    public function getResponseCode()
    {
        return $this->serverResponseCode;
    }

    /**
     * cnbForm
     *
     * @param array $params
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function cnbForm($params)
    {
        $language = 'ru';
        if (isset($params['language']) && $params['language'] == 'en') {
            $language = 'en';
        }

        $params    = $this->cnbParams($params);
        $data      = $this->encodeParams($params);
        $signature = $this->cnbSignature($params);

        return sprintf('
            <form method="POST" action="%s" accept-charset="utf-8">
                %s
                %s
                <input type="image" src="//static.liqpay.ua/buttons/p1%s.radius.png" name="btn_text" />
            </form>
            ',
            $this->checkoutUrl,
            sprintf('<input type="hidden" name="%s" value="%s" />', 'data', $data),
            sprintf('<input type="hidden" name="%s" value="%s" />', 'signature', $signature),
            $language
        );
    }

    /**
     * cnbForm raw data for custom form
     *
     * @param $params
     * @return array
     */
    public function cnbFormRaw($params)
    {
        $params = $this->cnbParams($params);

        return array(
            'url'       => $this->checkoutUrl,
            'data'      => $this->encodeParams($params),
            'signature' => $this->cnbSignature($params)
        );
    }

    /**
     * cnbSignature
     *
     * @param array $params
     *
     * @return string
     */
    public function cnbSignature($params)
    {
        $params      = $this->cnbParams($params);
        $private_key = $this->privateKey;

        $json      = $this->encodeParams($params);
        $signature = $this->strToSign($private_key . $json . $private_key);

        return $signature;
    }

    /**
     * cnbParams
     *
     * @param array $params
     *
     * @return array $params
     */
    private function cnbParams($params)
    {
        $params['public_key'] = $this->publicKey;

        if (!isset($params['version'])) {
            throw new \InvalidArgumentException('version is null');
        }
        if (!isset($params['amount'])) {
            throw new \InvalidArgumentException('amount is null');
        }
        if (!isset($params['currency'])) {
            throw new \InvalidArgumentException('currency is null');
        }
        if (!in_array($params['currency'], $this->supportedCurrencies)) {
            throw new \InvalidArgumentException('currency is not supported');
        }
        if ($params['currency'] == self::CURRENCY_RUR) {
            $params['currency'] = self::CURRENCY_RUB;
        }
        if (!isset($params['description'])) {
            throw new \InvalidArgumentException('description is null');
        }

        return $params;
    }

    /**
     * encodeParams
     *
     * @param array $params
     * @return string
     */
    private function encodeParams($params)
    {
        return base64_encode(json_encode($params));
    }

    /**
     * decodeParams
     *
     * @param string $params
     * @return array
     */
    public function decodeParams($params)
    {
        return json_decode(base64_decode($params), true);
    }

    /**
     * strToSign
     *
     * @param string $str
     *
     * @return string
     */
    public function strToSign($str)
    {
        $signature = base64_encode(sha1($str, 1));

        return $signature;
    }
}
