# Hybrid authentication plugin for Neos CMS.

A Neos CMS plugin which enables login with Google, Github and Facebook to the Neos CMS backend.

![HybridAuth](https://raw.githubusercontent.com/patriceckhart/NeosRulez.HybridAuth/master/HybridAuth.png)

## Installation

The NeosRulez.HybridAuth package is listed on packagist (https://packagist.org/packages/neosrulez/hybridauth) - therefore you don't have to include the package in your "repositories" entry any more.

Just add the following line to your require section:

```
"neosrulez/hybridauth": "*"
```

## Settings.yaml

You can configure everything in Settings.yaml:

```
NeosRulez:
  HybridAuth:
    Provider:
      github:
        clientId: '4859d7d83243241666ca8'
        clientSecret: '87384sdfsdf05cc7a9b91ee4ae2b7d2081394'
        callBackUri: 'http://dev.neos1.loc/neosrulez-hybridauth-github-auth'
        defaultRole: 'Neos.Neos:Administrator'
      facebook:
        facebookAppId: '8012324325000'
        facebookAppSecret: '92f471a234234dbd3e76c045181c3'
        redirectUri: 'http://dev.neos1.loc/neosrulez-hybridauth-facebook-auth'
        defaultRole: 'Neos.Neos:Administrator'
      google:
        googleClientId: '4859d6867671666ca8'
        googleClientSecret: '87384bf2fgh546459b91ee4ae2b7d2081394'
        callBackUri: 'http://dev.neos1.loc/neosrulez-hybridauth-google-auth'
        defaultRole: 'Neos.Neos:Administrator'
```

## Author

* E-Mail: mail@patriceckhart.com
* URL: http://www.patriceckhart.com
