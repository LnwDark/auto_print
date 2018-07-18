import sys
import os
import cups
import time


# pathnow ="/home/snilli/Data/project/ng_management/file_print/"
pathnow = sys.argv[1]

# # cd to dir
path, dir,files = next(os.walk(pathnow))
file_count = len(files)

if file_count > 0:
        # start cups
        conn = cups.Connection()
        printer = list(conn.getPrinters().keys())[0]
        
        # printer name

        # print (printer)

        # start print file then return job state 
        # printer_returns = conn.printFile(printer, pathnow + "/" + files[0], "statement financial", {})
        printer_returns = conn.printFile(printer, sys.argv[1] + "/" + sys.argv[2], "statement financial", {})
        
        while True:
                printer_stat = conn.getJobAttributes(printer_returns)["job-state"]
                # print (printer_stat)

                if printer_stat == 9:
                        # print os.remove(pathnow + "/" + files[0])
                        os.remove(pathnow + "/" + sys.argv[2])
                        print("ok")
                        break
                else:
                        time.sleep(2)