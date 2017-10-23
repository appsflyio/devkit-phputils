# About appsfly.io Dev Kit PHP Utils
This library contains resources to help communicate with appsfly.io execution server.
For all communications with execution server, your application should be registered and a secret key needs to be generated. 

Please contact integrations@appsfly.io for your credientials.

#  Get Started
 <a name="SECRET_KEY"></a><a name="APP_KEY"></a><a name="EXECUTOR_URL"></a>
#### Application Params
| Key | Description |
| --- | --- |
| SECRET_KEY   | Secret Key is required for encryption. Secret Key should be generated on the Appsfly publisher dashboard |
| APP_KEY  | Application key to identify the publisher instance|
| EXECUTOR_URL | Url to reach appsfly.io Microservices |

**NOTE:** Above params are needed for checksum generation. Please refer to the methods mention below.

 <a name="MODULE_HANDLE"></a> <a name="UUID"></a>
#### Micro Module Params

| Key | Description |
| --- | --- |
| MODULE_HANDLE  | Each micromodule of a service provider is identified by MODULE_HANDLE |
| UUID  | UniqueID to identify user session|

 <a name="INTENT"></a> <a name="PAYLOAD"></a>
#### Intent Params
| Key | Description |
| --- | --- |
| INTENT | Intent is like an endpoint you are accessing to send messages |
| PAYLOAD | Data payload |

# Integration options  

### Option 1: SDK
The SDK can be included to handle authorization. There is no need for you to handle checksum generation and verification.
