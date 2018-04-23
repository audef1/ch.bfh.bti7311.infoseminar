# STUN Protocol

## STUN Messages  
STUN messages are TLV (type-length-value) encoded using big endian (network ordered) binary. All STUN messages start with a STUN header, followed by a STUN payload. The payload is a series of STUN attributes (explained in more detail later in this article), the set of which depends on the message type.  

The STUN header contains:

**0x0001** : Binding Request  
**0x0101** : Binding Response  
**0x0111** : Binding Error Response  
**0x0002** : Shared Secret Request  
**0x0102** : Shared Secret Response  
**0x0112** : Shared Secret Error Response  

Message length – Indicates the total length of the STUN payload in bytes but does not include the 20 bytes header.
Transaction id –Is used to correlate requests and responses.

## STUN Protocol Attributes  
### 0x0001: MAPPED-ADDRESS  
This attribute contains an IP address and port. It is always placed in the Binding Response, and it indicates the source IP address and port the server saw in the Binding Request sent from the client, i.e.; the STUN client’s public IP address and port where it can be reached from the internet.  
### 0x0002: RESPONSE-ADDRESST  
This attribute contains an IP address and port and is an optional attribute, typically in the Binding Request (sent from the STUN client to the STUN server). It indicates where the Binding Response (sent from the STUN server to the STUN client) is to be sent. If this attribute is not present in the Binding Request, the Binding Response is sent to the source IP address and port of the Binding Request which is attribute 0x0001: MAPPED-ADDRESS.  
### 0x0003: CHANGE-REQUEST  
This attribute, which is only allowed in the Binding Request and optional, contains two flags; to control the IP address and port used to send the response. These flags are called “change IP” and “change Port” flags. The “change IP” and “change Port” flags are useful for determining whether the client is behind a restricted cone NAT or restricted port cone NAT. They instruct the server to send the Binding Responses from a different source IP address and port.  
### 0x0004: SOURCE-ADDRESS  
This attribute is usually present in Binding Responses; it indicates the source IP address and port where the response was sent from, i.e. the IP address of the machine the client is running on (typically an internal private IP address). It is very useful as from this attribute the STUN server can detect twice NAT configurations.  
### 0x0005: CHANGED-ADDRESS  
This attribute is usually present in Binding Responses; it informs the client of the source IP address and port that would be used if the client requested the “change IP” and “change port” behaviour.  
### 0x0006: USERNAME  
This attribute is optional and is present in a Shared Secret Response with the PASSWORD attribute. It serves as a means to identify the shared secret used in the message integrity check.  
### 0x0007: PASSWORD  
This attribute is optional and only present in Shared Secret Response along with the USERNAME attribute. The value of the PASSWORD attribute is of variable length and used as a shared secret between the STUN server and the STUN client.  
### 0x0008: MESSAGE-INTEGRITY  
This attribute must be the last attribute in a STUN message and can be present in both Binding Request and Binding Response. It contains HMAC-SHA1 of the STUN message.  
### 0x0009: ERROR-CODE  
This attribute is present in the Binding Error Response and Shared Secret Error Response only. It indicates that an error has occurred and indicates also the type of error which has occurred. It contains a numerical value in the range of 100 to 699; which is the error code and also a textual reason phrase encoded in UTF-8 describing the error code, which is meant for the client.  
### 0x000a: UNKNOWN-ATTRIBUTES  
This attribute is present in the Binding Error Response or Shared Secret Error response when the error code is 420; some attributes sent from the client in the Request are unknown and the server does not understand them.  
### 0x000b: REFLECTED-FROM  
This attribute is present only in Binding Response and its use is to provide traceability so the STUN server cannot be used as part of a denial of service attack. It contains the IP address of the source from where the request came from, i.e. the IP address of the STUN client.  

## STUN Server error codes  
| 400 | Bad request; the request was malformed. Client must modify request and try sending it again. |
| 420 | Unknown attribute; the server did not understand an attribute in the request. |
| 430 | Stale credentials; the shared secret sent in the request is expired; the client should obtain a new shared secret. |
| 432 | Missing username; the username attribute is not present in the request. |
| 500 | Server error; temporary error and the client should try to send the request again. |