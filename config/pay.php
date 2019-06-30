<?php
    return [
        // 支付包
        'alipay' => [
            'app_id'         => '2016092500593434',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA1WP5ubu9pDEOdWue4IvJNKPxPk8+0tfiHYz7CgaGgaGl/ZeWhspqAiC6XsostjWAlV9f0pmyddwwQehKjJEKJSeYDFEyCgO8iJ4Sfue+ALDLolpfNUDSPJG9qUnzVJVAVN2T7vvmnAfvb/kUM1r81tfQLuIVO+Fybf7thpvzyWp4Vadq79OBptZreRLDc6uWXUhgvbHbDhP8JWWKP8TSJWVtLxmXC3ghAcZOMqh/jAZpbc4MYoNaN50we1oFa/+foMpt+bHq/bez9QcekThBez4suU8MXdEZj8Yq1EmcMOsjNCL+S+7WWfhD6ZRlc74Dk7/Jv0TVGz+Tz0LNYeBdsQIDAQAB',
            'private_key'    => 'MIIEowIBAAKCAQEArw3+/IUFog59a5IGWuLyPOPcFtLjcRf0Zkq2CBhjg3luo/sT0CnAaL/5RiM/QmS0qnAqx47Y52ra9qQEC0dn0vgAJaMAIULLenFOBFLFLCZ1MCkj45VFzIMT4eCk647KVePLEBe8ytqJDaTshS0uyfOPFnLO7B/TdOJg3SR7cxNnfy3dIv3pVUMCQEp8E/YI+XWNLnBWYdesmdnmcI12tJT953bsfrLMeG4rtv32JZgLkU6ZlgDvwPW8bTRrGq66n7NVUVIFwP2ahoEirs+EUIFVXbLaY0+Ird/g8i/GOs1Vzyd6Fo82CKjBVepPriCu3F5vb7B1DWdla0UDibLIAwIDAQABAoIBABcpM+Z3NyKU5jU4Uczun/w8bZ87ccpB0B1En0b86xW3GFNr4dg13fY+CB4mhbUkG989DfvvQ3WC5suhMcPIQ81e8K4KHfdIniFqIldiGCJaSEECAHSZCG4hnZzSGx/reYvZosFTUrBIL7/1ZTHNo5YmunTO5d/J6jFZzlUUAZ1c6MJEe1M4ffA7V7IRNcU7U1c+5o8hitZgOCIW0xa/KEllorvch9hKNmxjQQsKQqJmO8IDExEfCtOq2BRfqbYjOBmmljZV5oh2JeTxxRw3u6fZV1ZD5XyNN24ZGXqVuSSJCYP5yHBHZDFfXzjJZ1pR07jIQN9rwq9fMk1OdBg6QWECgYEA4Qpv8HY1D+EwBYomDhX7aWqnS4AwhbV5tz5KhH2nxwllPA0frRSeZVyEGMRC+h3nKQPbruEwusGkSqlcNrk9awCL4dspD9fDD0iHWxb4XIPhT4p2I2Krnktziq5MtkfdicqDVIMyWtzLiwR3cYKoHGRPHDktphnbBhWkoGE0IpMCgYEAxyMhm8nuC2ppYCosWMfyoo1pM+RkiyW8vnbIPXDO+0M01Nn6jU2d/d5tDtXvk2h5Omhmz01ylsJF2Vt000h3tezXF3BAfq8Ecix6Yh7bYY9dDrkwvE20txAgAE0uU4VmAiJ7GLsi24/nO5GV0d3ZDetKpfo8AefFmVVtVDqF+tECgYBTfGTEx4Wt63O+Sl8N0LfhhtCjoN3fbNDH21MXzeoFXAXzfkbnFgQhRG45Je5XDero+2ZvfVlvn1EM5cGxB42yeZRraLvWBcx2igi1EVN4NvDKamqjfAKBCirGIx2Qbh7Q9JE+NCHlNY5Jd5G8SaWGSuxSYx/9RBBONI9LdGQ8AwKBgQCtDrDUbIY80XtGISBs/0azUWVNvXxLGL6QXzXhfznBTkSJfe2qAvv8deIc9HrBhhdkVPqTyWB999Mv87TxMJcoOO0r51eFQKACgPjScLKCdE6Qzwu1eWpFdPP6jxhlaRafYEvN0EOYv9RaBklHGx7YY9R5rZ+coEku2firLDjnIQKBgAD8owaOk++rED4e9CJnRJf/EjhUKZW3ldwQ9ap9HO09PantGlSf4rmJfcSEtfXAaAHO4n53SbwUGDnkHcCZCwHI46xTlT7MiYbAOCKfT0LwnRyRL0iwy49unJQbgXZqmSgFC9tGID33j/R7Pc9vNNf/PTdoRPWoomUcGvXNRf9/',
            'log'            => [
                'file' => storage_path('logs/alipay.log'),
            ],
        ],

        // 微信
        'wechat' => [
            'app_id'      => '',
            'mch_id'      => '',
            'key'         => '',
            'cert_client' => '',
            'cert_key'    => '',
            'log'         => [
                'file' => storage_path('logs/wechat_pay.log'),
            ],
        ],
    ];
?>