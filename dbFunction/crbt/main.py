#!F:\Python\Python39\python.exe
import re
import sys
import traceback

import requests
from log import getLogger

if __name__ == '__main__':

    proxies = {
    "http": None,
    "https": None,
    }
 
    print(sys.argv[1],sys.argv[2])
    endpoint = "http://10.68.198.66/SLTCrbt/ProvisionCallback.php";
    
    headers= {'content-type':'text/xml'}

    logger = getLogger('crbt', 'F:\\xampp\\htdocs\\IMS\\dbFunction\\crbt\\logs\\crbt')

    

    try:
        xmlfile = open('F:\\xampp\\htdocs\\IMS\\dbFunction\\crbt\\files\\CallBackStatus.xml', 'r')
        body = xmlfile.read()

        response = requests.request("POST",endpoint,headers=headers,
                                    data=body.format(msisdn=sys.argv[1],status= sys.argv[2] ), proxies=proxies)
                                    
        print(response.request.body)
        logger.info("Start : =========================================================================")
        logger.info(str(sys.argv[1])+" "+str(sys.argv[2]))

        logger.info(response.request.body)

        logger.info("Response : =================================")
        logger.info(response.text)
        

        ResultCode = re.findall("<return xsi:type=\"xsd:string\">(.*?)</return>", str(response.content))
        print(ResultCode[0])
        logger.info(ResultCode[0])		
        logger.info("End : =========================================================================")
    except Exception as e:
        logger.error(e)
        print("Exception : %s" % traceback.format_exc())
        logger.info("End : =========================================================================")

