#!F:\Python\Python39\python.exe
import re
import traceback
import requests
from log import getLogger
import xml.etree.ElementTree as ET

logger = getLogger('zte', 'F:\\xampp\\htdocs\\IMS\\dbFunction\\NMSCon\\logs\\zte')
endpoint = "http://10.64.73.49:9090/axis2/services/NeManagementService/";

proxies = {
    "http": None,
    "https": None,
}


class Ztecreate:
    def zteVlan(self, indata, inval, inval2):
        try:
            xmlfile = open('F:\\xampp\\htdocs\\IMS\\dbFunction\\NMSCon\\files\\zte\\' + self, 'r')
            data = xmlfile.read()

            for key in indata:
                value = indata[key]

                data = data.replace(key, value)
                # print(key, value)

            # print(data)
            response = requests.request("POST", endpoint,
                                        data=data, proxies=proxies)

            logger.info("Start : =========================================================================")
            logger.info("Input Data : "+str(indata))
            logger.info("command xml : "+str(self))
            logger.info(response.request.body)
            logger.info("Response : =================================")
            logger.info(response.text)
            
            count = 1
            data = {}
            root = ET.fromstring(response.content)

            for resultc in root.iter('statusCode'):
                ResultCode = resultc.text

            for resultd in root.iter('statusDesc'):
                ResultDesc = resultd.text
            # print(ResultCode)
            # print(ResultDesc)

            for record in root.iter('record'):
                count = count + 1
                for param in record.iter('param'):
                    count = count + 1
                    for name in param.iter('name'):
                        if name.text != 'totalrecord':
                            count = count + 1
                            name = name.text
                            for value in param.iter('value'):
                                if count == 3:
                                    value = value.text
                                    if value == inval:
                                        if inval == 'Entree':
                                            data['EVLAN'] = value2
                                        else:
                                            data[value] = value2
                                    if value == inval2:
                                        data[value] = value2
                                if count == 4:
                                    value2 = value.text

                                count = 1
            # print(data)
            if (ResultCode == '0'):
                logger.info(data)			
                logger.info("End   : =========================================================================")
                return data
            else:
                logger.info(str(ResultCode) + '#' + str(ResultDesc))			
                logger.info("End   : =========================================================================")
                return ResultCode + '#' + ResultDesc
            # print(data)


        except Exception as e:
            print("Exception : %s" % traceback.format_exc())
            logger.error(e)
            logger.info("End   : =========================================================================")

    def zteCreate(self, indata):
        
        try:
            xmlfile = open('F:\\xampp\\htdocs\\IMS\\dbFunction\\NMSCon\\files\\zte\\' + self, 'r')
            data = xmlfile.read()

            for key in indata:
                value = indata[key]

                data = data.replace(key, value)
                # print(key, value)

            # print(data)
            response = requests.request("POST", endpoint,
                                        data=data, proxies=proxies)

            logger.info("Start : =========================================================================")
            logger.info("Input Data : "+str(indata))		
            logger.info("command xml : "+str(self))
            
            logger.info(response.request.body)
            logger.info("Response : =================================")
            logger.info(response.text)
            

            #root = ET.fromstring(response.content)
            #for resultc in root.iter('statusCode'):
                #ResultCode = resultc.text

            #for resultd in root.iter('statusDesc'):
                #ResultDesc = resultd.text
				
            ResultCode=re.findall("<statusCode>(.*?)</statusCode>", str(response.content))
            ResultDesc=re.findall("<statusDesc>(.*?)</statusDesc>", str(response.content))	
            # print(ResultCode)
            # print(ResultDesc)
            logger.info(str(ResultCode[0]) + '#' + str(ResultDesc[0]))			
            logger.info("End   : =========================================================================")
            return ResultCode[0] + '#' + ResultDesc[0]
            

        except Exception as e:
            print("Exception : %s" % traceback.format_exc())
            logger.error(e)
            logger.info("End   : =========================================================================")


class Ztedelete:
    def zteDelete(self):
        # FAB DELETE / VOICE DELETE
        try:
            xmlfile = open('F:\\xampp\\htdocs\\IMS\\dbFunction\\NMSCon\\files\\zte\\FTTH_DEL_ONU.xml', 'r')
            data = xmlfile.read()

            for key in self:
                value = self[key]

                data = data.replace(key, value)
                # print(key, value)

            print(data)
            response = requests.request("POST", endpoint,
                                        data=data, proxies=proxies)

            logger.info("Start : =========================================================================")
            logger.info("Input Data : "+str(self)) 			
            logger.info("command xml : FTTH_DEL_ONU.xml")
            logger.info(response.request.body)
            logger.info("Response : =================================")
            logger.info(response.text)
            

            root = ET.fromstring(response.content)
            for resultc in root.iter('statusCode'):
                ResultCode = resultc.text

            for resultd in root.iter('statusDesc'):
                ResultDesc = resultd.text

            # print(ResultDesc)
            logger.info(str(ResultCode[0]) + '#' + str(ResultDesc[0]))
            logger.info("End   : =========================================================================")
            return ResultCode + '#' + ResultDesc

        except Exception as e:
            print("Exception : %s" % traceback.format_exc())
            logger.error(e)
            logger.info("End   : =========================================================================")
