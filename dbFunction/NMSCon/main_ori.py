#!F:\Python\Python39\python.exe
import re
import sys
import json
from huawei import Huawei
from nokia import Nokia
from zte import Ztecreate, Ztedelete
import traceback
import requests
from log import getLogger
import xml.etree.ElementTree as ET




if __name__ == '__main__':
    data = json.loads(re.sub('\'', '\"', sys.argv[4]))

    if sys.argv[1] == 'ZTE':
        # DELETE
        if sys.argv[2] == 'FAB':
            if sys.argv[3] == 'FTTH_DEL_ONU':
                #print(data)		
                result = Ztedelete.zteDelete(data)
                print(result)


        # FAB CREATE
        if sys.argv[2] == 'FAB':
            if sys.argv[3] == 'FTTH_ZTE_ADDONU':
                #print(data)
                if data['ZTE_ONUTYPE'] == "1_GBPS":
                    data['ZTE_ONUTYPE'] = 'ZTE-F2866S'

                if data['ZTE_ONUTYPE'] == 'FTTH':
                    data['ZTE_ONUTYPE'] = 'ZTE-F660'

                result = Ztecreate.zteCreate('FTTH_ZTEADD_ONU.xml', data)
                print(result)

        if sys.argv[3] == 'FTTH_ZTE_BID_PROFILE':

            if data['FTTH_INTERNET_PKG'] == "1_GBPS":
                data['FTTH_INTERNET_PKG'] = '1G'

            if data['FTTH_INTERNET_PKG'] == 'FTTH':
                data['FTTH_INTERNET_PKG'] = '100M'

            if data['FTTH_ZTE_PROFILE'] == 'DOUBLEPLAY_VOICE_IPTV':
                result = Ztecreate.zteCreate('FTTH_ZTEX_BIDPIPTV.xml', data)
                print(result)

            elif data['FTTH_ZTE_PROFILE'] == 'TRIPLEPLAY_MULTIIPTV':
                result = Ztecreate.zteCreate('FTTH_ZTEX_BIDPIPTV.xml', data)
                print(result)

            else:
                result = Ztecreate.zteCreate('FTTH_ZTEX_BIDP.xml', data)
                print(result)

    # VOICE CREATE
    if sys.argv[2] == 'VOICE':
        if sys.argv[3] == 'FTTH_ZTE_ISERPOT':
            resultvlan = Ztecreate.zteVlan('lst_vlan.xml', data, 'VOBB', '')
            print(resultvlan)
            if "VOBB" not in resultvlan:
                data.update({'VOBB': ''})
            data.update(resultvlan)

            result = Ztecreate.zteCreate('FTTH_VSER_PORT.xml', data)
            print(result)

    # BB CREATE
    if sys.argv[2] == 'BB':
        if sys.argv[3] == 'FTTH_ZTE_ISERPOT':
            resultvlan = Ztecreate.zteVlan('lst_vlan.xml', data, 'Entree', 'SVLAN')
            print(resultvlan)
            data.update(resultvlan)

            result = Ztecreate.zteCreate('FTH_ISER_POT.xml', data)
            print(result)

        if sys.argv[3] == 'FTTH_INT_USRADD':
            result = Ztecreate.zteCreate('FTTH_INT_USRADD.xml', data)
            print(result)

    # IPTV CREATE
    if sys.argv[2] == 'IPTV':
        if sys.argv[3] == 'FTTH_ZTE_ISERPOT':
            resultvlan = Ztecreate.zteVlan('lst_vlan.xml', data, 'IPTV', 'IPTV_SVLAN')
            print(resultvlan)
            if "IPTV" not in resultvlan:
                data.update({'IPTV': ''})
            if "IPTV_SVLAN" not in resultvlan:
                data.update({'IPTV_SVLAN': ''})
            data.update(resultvlan)

            result = Ztecreate.zteCreate('FTTH_PSER_PORT.xml', data)
            print(result)

        if sys.argv[3] == 'FTTH_ZTE_IPTVSERA':
            result = Ztecreate.zteCreate('FTTH_ZTE_IPTVSERA.xml', data)
            print(result)

        if sys.argv[3] == 'FTTH_ZTE_IPTVSERB':
            result = Ztecreate.zteCreate('FTTH_ZTE_IPTVSERB.xml', data)
            print(result)

        if sys.argv[3] == 'FTTH_ZTE_IPTVSERC':
            result = Ztecreate.zteCreate('FTTH_ZTE_IPTVSERC.xml', data)
            print(result)

        if sys.argv[3] == 'FTTH_ZTE_IPTVSERD':
            result = Ztecreate.zteCreate('FTTH_ZTE_IPTVSERD.xml', data)
            print(result)

        if sys.argv[3] == 'FTTH_ZTE_IPTV2':
            result = Ztecreate.zteCreate('FTTH_ZTE_IPTVSERD.xml', data)
            print(result)

        if sys.argv[3] == 'FTTH_ZTE_IPTV3':
            result = Ztecreate.zteCreate('FTTH_ZTE_IPTVSERD.xml', data)
            print(result)

elif sys.argv[1] == 'HUAWEI':
    # FAB CREATE
    if sys.argv[2] == 'FAB':
        if sys.argv[3] == 'FTTH_HUW_ADDONT':
            print(data)

    # VOICE CREATE
    if sys.argv[2] == 'VOICE':
        if sys.argv[3] == 'FTH_CREATE_SER_PORT':
            print(data)

    # BB CREATE
    if sys.argv[2] == 'BB':
        if sys.argv[3] == 'FTH_CREATE_SER_PORT':
            print(data)

    # IPTV CREATE
    if sys.argv[2] == 'IPTV':
        if sys.argv[3] == 'FTH_CREATE_SER_PORT':
            print(data)

        if sys.argv[3] == 'FTTH_HUW_JOINT_NTV':
            print(data)

        if sys.argv[3] == 'FTTH_HUW_MOD_NTV':
            print(data)

elif sys.argv[1] == 'NOKIA':
    # FAB CREATE
    if sys.argv[2] == 'FAB':
        if sys.argv[3] == 'ADD_ONT_NOKIA':
            print(data)

    # VOICE CREATE
    if sys.argv[2] == 'VOICE':
        if sys.argv[3] == 'ADD_NK_HVOICE':
            print(data)

    # BB CREATE
    if sys.argv[2] == 'BB':
        if sys.argv[3] == 'ADD_NK_INTERNET':
            print(data)

    # IPTV CREATE
    if sys.argv[2] == 'IPTV':
        if sys.argv[3] == 'ADD_NK_IPTV':
            print(data)

else:
    print('Invalid MSAN')

	
	