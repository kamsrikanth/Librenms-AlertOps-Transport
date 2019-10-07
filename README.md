AlertOps LibreNMS Transport
================


Post AlertOps Alerts to Webex Teams


Configuration
------------
**In AlertOps Console**

*1) Create Inbound Integration in AlertOps based on LibreNMS template:*

*2) Save integration and generate URL*

*3) Copy URL to clipboard*


**In LibreNMS**

*1) Visit* `https://github.com/librenms/librenms/tree/master/LibreNMS/Alert/Transport`.

*2) Download AlertOps Transport php File*  

*3) Place Transport in Transport file.* (Located at `~/LibreNMS/Alert/Transport`) 

*4) In LibreNMS console, go to alert-transports page under Alerts*  

*5) Create Alert Transport & under Transport type select `AlertOps`*  

*6) If you'd like all alerts to be routed through AlertOps, Select default Alert*

*7) Reload LibreNMS*
