#!F:\Python\Python39\python.exe
import re
import traceback
import requests
from log import getLogger
import xml.etree.ElementTree as ET
from requests.auth import HTTPBasicAuth

#logger = getLogger('nokia', 'F:\\xampp\\htdocs\\IMS\\dbFunction\\NMSCon\\logs\\nokia')
endpoint = "http://10.68.136.52:8080/soap/services/ApcRemotePort/9.6";

proxies = {
    "http": None,
    "https": None,
}


class Nokiacreate:
    def nokiaCreate(self, indata):

        try:
            xmlfile = open('F:\\xampp\\htdocs\\IMS\\dbFunction\\NMSCon\\files\\nokia\\' + self, 'r')
            data = xmlfile.read()

            for key in indata:
                value = indata[key]

                data = data.replace(key, value)
                # print(key, value)

            # print(data)
            response = requests.request("POST", endpoint,
                                        data=data, proxies=proxies, auth=HTTPBasicAuth('nbiuser', 'nbiuser'))

            logger.info("Start : =========================================================================")
            logger.info("command xml : "+str(self))
            logger.info(response.request.body)
            logger.info("Response : =================================")
            logger.info(response.text)
            logger.info("End   : =========================================================================")

            ResultCode=re.findall("<ResultIndicator>(.*?)</ResultIndicator>", str(response.content))

            if len(ResultCode) > 0:
                return '0#' + str(ResultCode[0])
            else:
                ResultCode = re.findall("<message>(.*?)</message>", str(response.content))
                return '1#' + str(ResultCode[0])

        except Exception as e:
            result= '10#'+str(e)
            #print("Exception : %s" % traceback.format_exc())
            logger.error(e)
            return result


class Nokiadelete:
    def nokiaDelete(self, indata):
        # FAB DELETE / VOICE DELETE
        try:
            xmlfile = open('F:\\xampp\\htdocs\\IMS\\dbFunction\\NMSCon\\files\\nokia\\' + self, 'r')
            data = xmlfile.read()

            for key in indata:
                value = indata[key]

                data = data.replace(key, value)
                # print(key, value)

            print(data)
            response = requests.request("POST", endpoint,
                                        data=data, proxies=proxies, auth=HTTPBasicAuth('nbiuser', 'nbiuser'))

            logger.info("Start : =========================================================================")
            logger.info("command xml : "+str(self))
            logger.info(response.request.body)
            logger.info("Response : =================================")
            logger.info(response.text)
            logger.info("End   : =========================================================================")

            ResultCode=re.findall("<ResultIndicator>(.*?)</ResultIndicator>", str(response.content))
            if len(ResultCode) > 0:
                return '0#' + str(ResultCode[0])
            else:
                ResultCode = re.findall("<message>(.*?)</message>", str(response.content))
                return '1#' + str(ResultCode[0])

        except Exception as e:
            result= '10#'+str(e)
            #print("Exception : %s" % traceback.format_exc())
            logger.error(e)
            return result
