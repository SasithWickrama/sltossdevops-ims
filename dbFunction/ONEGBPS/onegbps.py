import multiprocessing
import random
import time
import db
import subprocess

import zte
from huawei import Huaweicreate, Huaweidelete
from nokia import Nokiacreate, Nokiadelete
from zte import Ztecreate, Ztedelete
from log import getLogger



def specific_string(length):
    sample_string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'  # define the specific string
    # define the condition for random string
    return ''.join((random.choice(sample_string)) for x in range(length))


def multiprocessing_func(x, pe):
    logger = getLogger(pe+'_prov', 'logs/'+pe)

    refid = specific_string(10)
    # logger.info("Request : %s" % ref + " - " + str(data))
    conn = db.DbConnection.dbconnOssRpt(self="")
    c = conn.cursor()
    sql = 'select MSAN_TYPE,DNAME,ONT_SN,ZTE_PORT,HUAWEI_PORT,NOKIA_PORT,V_PORT,REGID,BB_CIRCUIT,IPTV_COUNT,SPEED,ZTE_PROFILE,REC_ID from ONEG_OLDCCT_DETAILS where REGID=:REGID and PE_NO = :PE_NO and CCT_STATUS=:CCT_STATUS and ONT_SN is not null and REGID is not null   AND MOD(DBMS_ROWID.ROWID_ROW_NUMBER(ONEG_OLDCCT_DETAILS.ROWID), 10) = ' + str(
        x)
    c.execute(sql, ['0112937239', pe, '0'])

    for row in c:
        MSAN_TYPE, DNAME, ONT_SN, ZTE_PORT, HUAWEI_PORT, NOKIA_PORT, V_PORT, REGID, BB_CIRCUIT, IPTV_COUNT, SPEED, ZTE_PROFILE, REC_ID = row
        print(MSAN_TYPE, ONT_SN, ZTE_PORT, IPTV_COUNT)
        try:

            sql = "select distinct ZTE_PORT,HUAWEI_PORT,NOKIA_PORT,V_PORT,REGID from ONEG_NEWCCT_DETAILS where PE_NO= :PE_NO  and ONT_SN= :ONT_SN and REGID= :REGID"
            with conn.cursor() as cursor:
                cursor.execute(sql, [pe, ONT_SN, REGID])
                credata = cursor.fetchone()

                datadel = {}
                data = {}

                ref = refid + '_' + REGID
                if MSAN_TYPE == 'ZTE':
                    # DELETE

                    datadel['ADSL_ZTE_DNAME'] = DNAME
                    datadel['FTTH_ONT_SN'] = ONT_SN
                    datadel['FTTH_ZTE_PID'] = ZTE_PORT
                    datadel['REF_ID'] = str(ref)
                    datadel['PE'] = str(pe)



                    result = Ztedelete.zteDelete(datadel)
                    if result.split('#')[0] == '0':
                        # CREATE
                        try:
                            sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=1, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                            with conn.cursor() as cursor:
                                cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                conn.commit()
                        except conn.Error as error:
                            print('DB Error:' + str(error))

                        data['ADSL_ZTE_DNAME'] = DNAME
                        data['FTTH_ZTE_PID'] = credata[0]
                        data['FTTH_ONT_SN'] = ONT_SN
                        data['FTTH_HUW_VP'] = credata[3]
                        data['ZTE_NMS_REGID'] = str(credata[4])[1:10]
                        data['FTTH_ZTE_PROFILE'] = ZTE_PROFILE
                        data['FTTH_INTERNET_PKG'] = '100M'
                        data['REF_ID'] = ref
                        data['PE'] = str(pe)

                        if SPEED == "1_GBPS":
                            data['ZTE_ONUTYPE'] = 'ZTE-F2866S'
                            data['FTTH_INTERNET_PKG'] = '1G'

                        if SPEED == 'FTTH':
                            data['ZTE_ONUTYPE'] = 'ZTE-F660'
                            data['FTTH_INTERNET_PKG'] = '100M'

                        logger.info(ref+"  " + "Start : =========================================================================")
                        logger.info(ref+"  " + str(data))

                        #GET VLAN
                        resultvlan = Ztecreate.zteVlan('lst_vlan.xml', data, 'VOBB', '')
                        if "VOBB" not in resultvlan:
                            data.update({'VOBB': '0'})
                        data.update(resultvlan)
                        
                        resultvlanbb = Ztecreate.zteVlan('lst_vlan.xml', data, 'EVLAN', 'SVLAN')
                        if "EVLAN" not in resultvlanbb:
                            data.update({'EVLAN': '0'})
                        if "SVLAN" not in resultvlanbb:
                            data.update({'SVLAN': '0'})
                        data.update(resultvlanbb)
                        
                        resultvlanpeo = Ztecreate.zteVlan('lst_vlan.xml', data, 'IPTV', 'IPTV_SVLAN')
                        if "IPTV" not in resultvlanpeo:
                            data.update({'IPTV': ''})
                        if "IPTV_SVLAN" not in resultvlanpeo:
                            data.update({'IPTV_SVLAN': ''})
                        data.update(resultvlanpeo)

                        # FAB
                        resultfab = Ztecreate.zteCreate('FTTH_ZTEADD_ONU.xml', data)
                        logger.info(ref+"  " + "command xml : FTTH_ZTEADD_ONU.xml")
                        logger.info(ref+"  " + resultfab)
                        if resultfab.split('#')[0] == '0':
                            try:
                                sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=2, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                with conn.cursor() as cursor:
                                    cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                    conn.commit()
                            except conn.Error as error:
                                print('DB Error:' + str(error))

                            if SPEED == 'DOUBLEPLAY_VOICE_IPTV':
                                command = 'FTTH_ZTEX_BIDPIPTV.xml'
                            elif SPEED == 'TRIPLEPLAY_MULTIIPTV':
                                command = 'FTTH_ZTEX_MIPTV.xml'
                            else:
                                command = 'FTTH_ZTEX_BIDP.xml'

                            resultprof = Ztecreate.zteCreate(command, data)
                            if resultprof.split('#')[0] == '0':
                                try:
                                    sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=3, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                    with conn.cursor() as cursor:
                                        cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                        conn.commit()
                                except conn.Error as error:
                                    print('DB Error:' + str(error))

                                # VOICE
                                resultv = Ztecreate.zteCreate('FTTH_VSER_PORT.xml', data)
                                if resultv.split('#')[0] == '0':
                                    try:
                                        sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=4, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                        with conn.cursor() as cursor:
                                            cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                            conn.commit()
                                    except conn.Error as error:
                                        print('DB Error:' + str(error))

                                    # BB
                                    resultbb = Ztecreate.zteCreate('FTH_ISER_POT.xml', data)
                                    if resultbb.split('#')[0] == '0':
                                        try:
                                            sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=5, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                            with conn.cursor() as cursor:
                                                cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                                conn.commit()
                                        except conn.Error as error:
                                            print('DB Error:' + str(error))

                                        resultusr = Ztecreate.zteCreate('FTTH_INT_USRADD.xml', data)
                                        if resultusr.split('#')[0] == '0':
                                            try:
                                                sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=6, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                with conn.cursor() as cursor:
                                                    cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                                    conn.commit()
                                            except conn.Error as error:
                                                print('DB Error:' + str(error))

                                            # IPTV
                                            resultiptv = Ztecreate.zteCreate('FTTH_PSER_PORT.xml', data)
                                            if resultiptv.split('#')[0] == '0':
                                                try:
                                                    sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=7, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                    with conn.cursor() as cursor:
                                                        cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                                        conn.commit()
                                                except conn.Error as error:
                                                    print('DB Error:' + str(error))

                                                resultA = Ztecreate.zteCreate('FTTH_ZTE_IPTVSERA.xml', data)
                                                if resultA.split('#')[0] == '0':
                                                    try:
                                                        sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=8, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                        with conn.cursor() as cursor:
                                                            cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                                            conn.commit()
                                                    except conn.Error as error:
                                                        print('DB Error:' + str(error))

                                                    resultB = Ztecreate.zteCreate('FTTH_ZTE_IPTVSERB.xml', data)
                                                    if resultB.split('#')[0] == '0':
                                                        try:
                                                            sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=9, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                            with conn.cursor() as cursor:
                                                                cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                                                conn.commit()
                                                        except conn.Error as error:
                                                            print('DB Error:' + str(error))

                                                        resultC = Ztecreate.zteCreate('FTTH_ZTE_IPTVSERC.xml', data)
                                                        if resultC.split('#')[0] == '0':
                                                            try:
                                                                sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=10, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                                with conn.cursor() as cursor:
                                                                    cursor.execute(sql,
                                                                                   [result.split('#')[1], REGID, pe])
                                                                    conn.commit()
                                                            except conn.Error as error:
                                                                print('DB Error:' + str(error))

                                                            resultD = Ztecreate.zteCreate('FTTH_ZTE_IPTVSERD.xml', data)
                                                            if resultD.split('#')[0] == '0':
                                                                try:
                                                                    sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=11, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                                    with conn.cursor() as cursor:
                                                                        cursor.execute(sql,
                                                                                       [result.split('#')[1], REGID,
                                                                                        pe])
                                                                        conn.commit()
                                                                except conn.Error as error:
                                                                    print('DB Error:' + str(error))

                                                                if IPTV_COUNT == 2:
                                                                    result2 = Ztecreate.zteCreate('FTTH_ZTE_IPTV2.xml',
                                                                                                  data)
                                                                    if result2.split('#')[0] == '0':
                                                                        try:
                                                                            sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=12, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                                            with conn.cursor() as cursor:
                                                                                cursor.execute(sql,
                                                                                               [result.split('#')[1],
                                                                                                REGID, pe])
                                                                                conn.commit()
                                                                        except conn.Error as error:
                                                                            print('DB Error:' + str(error))

                                                                    else:
                                                                        try:
                                                                            sql = "update ONEG_NEWCCT_DETAILS set  CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                                            with conn.cursor() as cursor:
                                                                                cursor.execute(sql,
                                                                                               [result.split('#')[1],
                                                                                                REGID, pe])
                                                                                conn.commit()
                                                                        except conn.Error as error:
                                                                            print('DB Error:' + str(error))

                                                                if IPTV_COUNT == 3:
                                                                    result2 = Ztecreate.zteCreate('FTTH_ZTE_IPTV2.xml',
                                                                                                  data)
                                                                    if result2.split('#')[0] == '0':
                                                                        try:
                                                                            sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=12, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                                            with conn.cursor() as cursor:
                                                                                cursor.execute(sql,
                                                                                               [result.split('#')[1],
                                                                                                REGID, pe])
                                                                                conn.commit()
                                                                        except conn.Error as error:
                                                                            print('DB Error:' + str(error))

                                                                    else:
                                                                        try:
                                                                            sql = "update ONEG_NEWCCT_DETAILS set  CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                                            with conn.cursor() as cursor:
                                                                                cursor.execute(sql,
                                                                                               [result.split('#')[1],
                                                                                                REGID, pe])
                                                                                conn.commit()
                                                                        except conn.Error as error:
                                                                            print('DB Error:' + str(error))

                                                                    result3 = Ztecreate.zteCreate('FTTH_ZTE_IPTV3.xml',
                                                                                                  data)

                                                                    if result3.split('#')[0] == '0':
                                                                        try:
                                                                            sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=13, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                                            with conn.cursor() as cursor:
                                                                                cursor.execute(sql,
                                                                                               [result.split('#')[1],
                                                                                                REGID, pe])
                                                                                conn.commit()
                                                                        except conn.Error as error:
                                                                            print('DB Error:' + str(error))

                                                                    else:
                                                                        try:
                                                                            sql = "update ONEG_NEWCCT_DETAILS set  CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                                            with conn.cursor() as cursor:
                                                                                cursor.execute(sql,
                                                                                               [result.split('#')[1],
                                                                                                REGID, pe])
                                                                                conn.commit()
                                                                        except conn.Error as error:
                                                                            print('DB Error:' + str(error))



                                                            else:
                                                                try:
                                                                    sql = "update ONEG_NEWCCT_DETAILS set  CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                                    with conn.cursor() as cursor:
                                                                        cursor.execute(sql,
                                                                                       [result.split('#')[1], REGID,
                                                                                        pe])
                                                                        conn.commit()
                                                                except conn.Error as error:
                                                                    print('DB Error:' + str(error))

                                                        else:
                                                            try:
                                                                sql = "update ONEG_NEWCCT_DETAILS set  CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                                with conn.cursor() as cursor:
                                                                    cursor.execute(sql,
                                                                                   [result.split('#')[1], REGID, pe])
                                                                    conn.commit()
                                                            except conn.Error as error:
                                                                print('DB Error:' + str(error))

                                                    else:
                                                        try:
                                                            sql = "update ONEG_NEWCCT_DETAILS set  CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                            with conn.cursor() as cursor:
                                                                cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                                                conn.commit()
                                                        except conn.Error as error:
                                                            print('DB Error:' + str(error))

                                                else:
                                                    try:
                                                        sql = "update ONEG_NEWCCT_DETAILS set  CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                        with conn.cursor() as cursor:
                                                            cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                                            conn.commit()
                                                    except conn.Error as error:
                                                        print('DB Error:' + str(error))

                                            else:
                                                try:
                                                    sql = "update ONEG_NEWCCT_DETAILS set  CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                    with conn.cursor() as cursor:
                                                        cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                                        conn.commit()
                                                except conn.Error as error:
                                                    print('DB Error:' + str(error))

                                        else:
                                            try:
                                                sql = "update ONEG_NEWCCT_DETAILS set  CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                                with conn.cursor() as cursor:
                                                    cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                                    conn.commit()
                                            except conn.Error as error:
                                                print('DB Error:' + str(error))

                                    else:
                                        try:
                                            sql = "update ONEG_NEWCCT_DETAILS set  CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                            with conn.cursor() as cursor:
                                                cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                                conn.commit()
                                        except conn.Error as error:
                                            print('DB Error:' + str(error))

                                else:
                                    try:
                                        sql = "update ONEG_NEWCCT_DETAILS set  CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                        with conn.cursor() as cursor:
                                            cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                            conn.commit()
                                    except conn.Error as error:
                                        print('DB Error:' + str(error))

                            else:
                                try:
                                    sql = "update ONEG_NEWCCT_DETAILS set  CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                    with conn.cursor() as cursor:
                                        cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                        conn.commit()
                                except conn.Error as error:
                                    print('DB Error:' + str(error))

                        else:
                            try:
                                sql = "update ONEG_NEWCCT_DETAILS set CCT_STATUS=1, CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                                with conn.cursor() as cursor:
                                    cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                    conn.commit()
                            except conn.Error as error:
                                print('DB Error:' + str(error))

                        print(str(credata[4])[1:3])
                        # IMS DELETE
                        # HSS
                        # res = subprocess.check_output(
                        #     ['java', '-jar', 'files/jar/SLTUdrGui.jar', 'UDR_DEL_HSS','1','tpno#'+str(credata[4])[1:10]])
                        # print(type(res))
                        #
                        # # IMS CREATE
                        # reshss = subprocess.call(
                        #     ['java', '-jar', 'files/jar/SLTUdrGui.jar', 'UDR_ADDFTTH_HSS', '6','MSAN_TYPE#ZTE','ONT_PORT#'+str(credata[0]),'FTTH_ZTE_PID#'+str(credata[0]),'FTTH_HUW_VP#'+str(credata[3]),'ADSL_ZTE_DNAME#'+str(DNAME)], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
                        # print('reshss ' + str(reshss))
                        #
                        # resats = subprocess.call(
                        #     ['java', '-jar', 'files/jar/SLTUdrGui.jar', 'ADDATS','2','tpno#'+str(credata[4])[1:10],'source#'+str(credata[4])[1:3]], stdout=subprocess.PIPE, stderr=subprocess.PIPE)
                        # print('resats ' + str(resats))


                    else:
                        try:
                            sql = "update ONEG_OLDCCT_DETAILS set CCT_MESSAGE= :CCT_MESSAGE where  REGID= :REGID and PE_NO= :PE_NO"
                            with conn.cursor() as cursor:
                                cursor.execute(sql, [result.split('#')[1], REGID, pe])
                                conn.commit()
                        except conn.Error as error:
                            print('DB Error:' + str(error))

                if MSAN_TYPE == 'HUAWEI':
                    datadel['ADSL_ZTE_DNAME'] = DNAME
                    datadel['FTTH_HUW_FN'] = HUAWEI_PORT.split('#')[0]
                    datadel['FTTH_HUW_SN'] = HUAWEI_PORT.split('#')[1]
                    datadel['FTTH_HUW_PN'] = HUAWEI_PORT.split('#')[2]
                    datadel['FTTH_HUW_VP'] = V_PORT

                    # DELETE
                    result = Huaweidelete.huaweiDelete(datadel)
                    print(result)

                    # CREATE
                    data['ADSL_ZTE_DNAME'] = DNAME
                    data['FTTH_HUW_FN'] = credata[1].split('#')[0]
                    data['FTTH_HUW_SN'] = credata[1].split('#')[1]
                    data['FTTH_HUW_PN'] = credata[1].split('#')[2]
                    data['FTTH_HUW_VP'] = V_PORT

                    # FAB
                    resultfab = Huaweicreate.huaweiCreate('FTTH_HUW_ADDONT.xml', data)
                    print(resultfab)

                    # VOICE
                    resultvlan = Huaweicreate.huaweiVlan('HUAWEI_LIST_VLAN.xml', data, 'VOBB', '')
                    print(resultvlan)
                    if "VOBB" not in resultvlan:
                        data.update({'VOBB': '0'})
                    data.update(resultvlan)
                    result = Huaweicreate.huaweiCreate('HX_FTH_V_SER_POT_CRE.xml', data)
                    print(result)

                    # BB
                    resultvlanbb = Huaweicreate.huaweiVlan('HUAWEI_LIST_VLAN.xml', data, 'ADSL_VLAN', 'ADSL_SVLAN')
                    print(resultvlanbb)
                    if "ADSL_VLAN" not in resultvlan:
                        data.update({'ADSL_VLAN': '0'})
                    if "ADSL_SVLAN" not in resultvlan:
                        data.update({'ADSL_SVLAN': '0'})
                    data.update(resultvlanbb)

                    resultbb = Huaweicreate.huaweiCreate('HX_FTH_V_SER_POT_CRE.xml', data)
                    print(resultbb)

                    # IPTV
                    resultvlanpeo = Huaweicreate.huaweiVlan('HUAWEI_LIST_VLAN.xml', data, 'IPTV', 'IPTV_SVLAN')
                    print(resultvlanpeo)
                    if "IPTV_VLAN" not in resultvlan:
                        data.update({'IPTV_VLAN': '0'})
                    if "IPTV_SVLAN" not in resultvlan:
                        data.update({'IPTV_SVLAN': '0'})
                    data.update(resultvlanpeo)

                    resultiptv = Huaweicreate.huaweiCreate('HX_FTH_IPTV_SER_POT_CRE.xml', data)
                    print(resultiptv)

                    resultjoint = Huaweicreate.huaweiCreate('FTTH_HUW_JOINT_NTV.xml', data)
                    print(resultjoint)

                    resultmod = Huaweicreate.huaweiCreate('FTTH_HUW_MOD_NTV.xml', data)
                    print(resultmod)

                    if IPTV_COUNT == '2':
                        result21 = Huaweicreate.huaweiCreate('FTTH_IPTV_ADD_21.xml', data)
                        print(result21)

                        result22 = Huaweicreate.huaweiCreate('FTTH_IPTV_ADD_22.xml', data)
                        print(result22)

                        result23 = Huaweicreate.huaweiCreate('FTTH_IPTV_ADD_23.xml', data)
                        print(result23)

                    if IPTV_COUNT == '3':
                        result31 = Huaweicreate.huaweiCreate('FTTH_IPTV_ADD_31.xml', data)
                        print(result31)

                        result32 = Huaweicreate.huaweiCreate('FTTH_IPTV_ADD_32.xml', data)
                        print(result32)

                if MSAN_TYPE == 'NOKIA':
                    # DELETE
                    datadel['ADSL_ZTE_DNAME'] = DNAME
                    datadel['FTTH_ZTE_PID'] = NOKIA_PORT

                    result = Nokiadelete.nokiaDelete(datadel)
                    print(result)

                    # CREATE
                    data['ADSL_ZTE_DNAME'] = DNAME
                    data['FTTH_ZTE_PID'] = credata[2]
                    data['FTTH_ONT_SN'] = ONT_SN

                    if result.split('#')[0] == '0':
                        resultfab = Nokiacreate.nokiaCreate('ADD_ONT_NOKIA.xml', data)

                        if resultfab.split('#')[0] == '0':
                            if BB_CIRCUIT != '':
                                resultpeo = Nokiacreate.nokiaCreate('ADD_NK_INTERNET.xml', data)
                                print(result)

                            if IPTV_COUNT > 0:
                                result = Nokiacreate.nokiaCreate('ADD_NK_IPTV.xml', data)
                                print(result)
                        else:
                            print(result)
                    else:
                        print(result)
        except conn.Error as error:
            print('Error occurred:' + str(error))


if __name__ == '__main__':
    pe = 'PE20220115201'
    starttime = time.time()
    processes = []
    for i in range(0, 10):
        p = multiprocessing.Process(target=multiprocessing_func, args=(i, pe))
        processes.append(p)
        p.start()
    # multiprocessing_func(i)
    for process in processes:
        process.join()

