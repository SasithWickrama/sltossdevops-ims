#!F:\Python\Python39\python.exe
import re
import traceback
import requests
from log import getLogger
import xml.etree.ElementTree as ET


endpoint = "http://10.64.73.49:9090/axis2/services/NeManagementService/";

proxies = {
    "http": None,
    "https": None,
}


class Ztecreate:
    def zteVlan(self, indata, inval, inval2):
        try:
            logger = getLogger(indata['PE'], 'F:\\xampp\\htdocs\\IMS\\dbFunction\\ONEGBPS\\logs\\zte\\')
            xmlfile = open('F:\\xampp\\htdocs\\IMS\\dbFunction\\ONEGBPS\\files\\zte\\' + self, 'r')
            data = xmlfile.read()

            for key in indata:
                value = indata[key]

                data = data.replace(key, str(value))
                # print(key, value)

            # print(data)
            logger.info(indata[
                            'REF_ID'] + "  " + "Start : =========================================================================")
            logger.info(indata['REF_ID'] + "  " + "command xml : " + str(self))
            logger.info(indata['REF_ID'] + "  " + "data : " + str(indata))

            response = requests.request("POST", endpoint,
                                        data=data, proxies=proxies)

            logger.info(indata['REF_ID'] + "  " + str(response.request.body))
            logger.info(indata['REF_ID'] + "  " + "Response : =================================")
            logger.info(indata['REF_ID'] + "  " + str(response.text))
            logger.info(indata[
                            'REF_ID'] + "  " + "End   : =========================================================================")
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
                return data
            else:
                return ResultCode + '#' + ResultDesc
            # print(data)


        except Exception as e:
            result = '10#' + str(e)
            # print("Exception : %s" % traceback.format_exc())
            logger.error(indata['REF_ID'] + "  " + str(e))
            logger.info(indata[
                            'REF_ID'] + "  " + "End   : =========================================================================")
            return result

    def zteCreate(self, indata):

        try:
            logger = getLogger(indata['PE'], 'F:\\xampp\\htdocs\\IMS\\dbFunction\\ONEGBPS\\logs\\zte\\')
            xmlfile = open('F:\\xampp\\htdocs\\IMS\\dbFunction\\ONEGBPS\\files\\zte\\' + self, 'r')
            data = xmlfile.read()

            for key in indata:
                value = indata[key]

                data = data.replace(key, str(value))
                # print(key, value)

            # print(data)
            logger.info(indata[
                            'REF_ID'] + "  " + "Start : =========================================================================")
            logger.info(indata['REF_ID'] + "  " + "command xml : " + str(self))
            logger.info(indata['REF_ID'] + "  " + "data : " + str(indata))

            # response = requests.request("POST", endpoint,
            #                             data=data, proxies=proxies)
            #
            # logger.info(indata['REF_ID']+"  " + str(response.request.body))
            # logger.info(indata['REF_ID']+"  " + "Response : =================================")
            # logger.info(indata['REF_ID']+"  " + str(response.text))
            logger.info(indata[
                            'REF_ID'] + "  " + "End   : =========================================================================")

            # root = ET.fromstring(response.content)
            # for resultc in root.iter('statusCode'):
            #     ResultCode = resultc.text
            #
            # for resultd in root.iter('statusDesc'):
            #     ResultDesc = resultd.text
            # # print(ResultCode)
            # # print(ResultDesc)
            # return ResultCode + '#' + ResultDesc
            return '0#success'

        except Exception as e:
            result = '10#' + str(e)
            # print("Exception : %s" % traceback.format_exc())
            logger.error(indata['REF_ID'] + "  " + str(e))
            logger.info(indata[
                            'REF_ID'] + "  " + "End   : =========================================================================")
            return result


class Ztedelete:
    def zteDelete(self):
        # FAB DELETE / VOICE DELETE
        print(self)
        try:
            logger = getLogger(self['PE'], 'F:\\xampp\\htdocs\\IMS\\dbFunction\\ONEGBPS\\logs\\zte\\')
            xmlfile = open('F:\\xampp\\htdocs\\IMS\\dbFunction\\ONEGBPS\\files\\zte\\FTTH_DEL_ONU.xml', 'r')
            data = xmlfile.read()

            for key in self:
                value = self[key]

                data = data.replace(key, str(value))
                # print(key, value)

            # print(data)
            logger.info(self[
                            'REF_ID'] + "  " + "Start : =========================================================================")
            logger.info(self['REF_ID'] + "  " + "command xml : FTTH_DEL_ONU.xml")
            logger.info(self['REF_ID'] + "  " + "data : " + str(self))
            # response = requests.request("POST", endpoint,
            #                             data=data, proxies=proxies)
            #
            # logger.info(self['REF_ID']+"  " + str(response.request.body))
            # logger.info(self['REF_ID']+"  " + "Response : =================================")
            # logger.info(self['REF_ID']+"  " + str(response.text))
            logger.info(self[
                            'REF_ID'] + "  " + "End   : =========================================================================")

            # root = ET.fromstring(response.content)
            # for resultc in root.iter('statusCode'):
            #     ResultCode = resultc.text
            #
            # for resultd in root.iter('statusDesc'):
            #     ResultDesc = resultd.text
            #
            # # print(ResultDesc)
            # return ResultCode + '#' + ResultDesc
            return '0#success'
        except Exception as e:
            result = '10#' + str(e)
            # print("Exception : %s" % traceback.format_exc())
            logger.error(self['REF_ID'] + "  " + str(e))
            logger.info(self[
                            'REF_ID'] + "  " + "End   : =========================================================================")
            return result
