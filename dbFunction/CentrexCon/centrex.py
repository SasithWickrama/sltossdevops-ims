#!F:\Python\Python39\python.exe
import re

import requests

from log import getLogger

logger = getLogger('centrex', 'logs/centrex')
endpoint = "http://10.68.128.3:8080/spg";

proxies = {
    "http": None,
    "https": None,
}


class Centrex:
    def centAdd(self):
        try:
            xmlfile = open('F:/xampp/htdocs/IMS/dbFunction/CentrexCon/files/CentrexAdd.xml', 'r')
            data = xmlfile.read()

            for key in self:
                value = self[key]

                data = data.replace(key, str(value))

            logger.info(self['REF_ID'] + "  " + "Start : =========================================================================")
            logger.info(self['REF_ID'] + "  " + "command xml : CentrexAdd.xml")

            response = requests.request("POST", endpoint,
                                        data=data, proxies=proxies)


            logger.info(self['REF_ID'] + "  " + str(response.request.body))
            logger.info(self['REF_ID'] + "  " + "Response : =================================")
            logger.info(self['REF_ID'] + "  " + str(response.text))

            ResultCode = re.findall("<m:ResultCode>(.*?)</m:ResultCode>", str(response.content))
            ResultDesc = re.findall("<m:ResultDesc>(.*?)</m:ResultDesc>", str(response.content))

            logger.info(self['REF_ID'] + "  " + str(ResultCode[0])+'#'+str(ResultDesc[0]))
            logger.info(self['REF_ID'] + "  " + "End   : =========================================================================")

            return str(ResultCode[0])+'#'+str(ResultDesc[0])

        except Exception as e:
            # print("Exception : %s" % traceback.format_exc())
            logger.error(self['REF_ID'] + "  " + str(e))
            logger.info(self['REF_ID'] + "  " + "End   : =========================================================================")
            return str(e)


    def centRmv(self):
        try:
            xmlfile = open('F:/xampp/htdocs/IMS/dbFunction/CentrexCon/files/CentrexRmv.xml', 'r')
            data = xmlfile.read()

            for key in self:
                value = self[key]

                data = data.replace(key, str(value))

            logger.info(self['REF_ID'] + "  " + "Start : =========================================================================")
            logger.info(self['REF_ID'] + "  " + "command xml : CentrexRmv.xml")

            response = requests.request("POST", endpoint,
                                        data=data, proxies=proxies)


            logger.info(self['REF_ID'] + "  " + str(response.request.body))
            logger.info(self['REF_ID'] + "  " + "Response : =================================")
            logger.info(self['REF_ID'] + "  " + str(response.text))

            ResultCode = re.findall("<m:ResultCode>(.*?)</m:ResultCode>", str(response.content))
            ResultDesc = re.findall("<m:ResultDesc>(.*?)</m:ResultDesc>", str(response.content))

            logger.info(self['REF_ID'] + "  " + str(ResultCode[0])+'#'+str(ResultDesc[0]))
            logger.info(self['REF_ID'] + "  " + "End   : =========================================================================")

            return str(ResultCode[0])+'#'+str(ResultDesc[0])

        except Exception as e:
            # print("Exception : %s" % traceback.format_exc())
            logger.error(self['REF_ID'] + "  " + str(e))
            logger.info(self['REF_ID'] + "  " + "End   : =========================================================================")
            return str(e)


    def centDigitMap(self):
        try:
            xmlfile = open('F:/xampp/htdocs/IMS/dbFunction/CentrexCon/files/CentrexDigitMap.xml', 'r')
            data = xmlfile.read()

            for key in self:
                value = self[key]

                data = data.replace(key, str(value))

            logger.info(self['REF_ID'] + "  " + "Start : =========================================================================")
            logger.info(self['REF_ID'] + "  " + "command xml : CentrexDigitMap.xml")

            response = requests.request("POST", endpoint,
                                        data=data, proxies=proxies)


            logger.info(self['REF_ID'] + "  " + str(response.request.body))
            logger.info(self['REF_ID'] + "  " + "Response : =================================")
            logger.info(self['REF_ID'] + "  " + str(response.text))

            ResultCode = re.findall("<m:ResultCode>(.*?)</m:ResultCode>", str(response.content))
            ResultDesc = re.findall("<m:ResultDesc>(.*?)</m:ResultDesc>", str(response.content))

            logger.info(self['REF_ID'] + "  " + str(ResultCode[0])+'#'+str(ResultDesc[0]))
            logger.info(self['REF_ID'] + "  " + "End   : =========================================================================")

            return str(ResultCode[0])+'#'+str(ResultDesc[0])

        except Exception as e:
            # print("Exception : %s" % traceback.format_exc())
            logger.error(self['REF_ID'] + "  " + str(e))
            logger.info(self['REF_ID'] + "  " + "End   : =========================================================================")
            return str(e)
