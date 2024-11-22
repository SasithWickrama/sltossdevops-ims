import json
import random
import re
import sys

from centrex import Centrex

def specific_string(length):
    sample_string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'  # define the specific string
    # define the condition for random string
    return ''.join((random.choice(sample_string)) for x in range(length))


if __name__ == '__main__':
    data = json.loads(re.sub('\'', '\"', sys.argv[2]))
	
    refid = specific_string(10)
    data['REF_ID'] = refid
    	

    if sys.argv[1] == 'ADD':
        result = Centrex.centAdd(data)
        print(result)

    if sys.argv[1] == 'RMV':
        result = Centrex.centRmv(data)
        print(result)

    if sys.argv[1] == 'DIGITMAP':
        result = Centrex.centDigitMap(data)
        print(result)
