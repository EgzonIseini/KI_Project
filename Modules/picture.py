"""
    Main picture class used. Used to link the pictures with Python objects. 

    Includes fields to store information about the pictures and useful methods.
"""

import os
import Modules.constants as const
import Modules.exception as exception
import logging

logging.getLogger().setLevel(logging.INFO)

class Picture:
    def __init__(self, path=const.DEFAULT_PATH):
        self.path = path    

        self.name = const.DEFAULT_NAME
        self.extension = const.DEFAULT_EXT
        self.description = const.DEFAULT_DESCRIPTION

        if path == const.DEFAULT_PATH: logging.info("Created an empty picture object.")
        else:
            self.name = os.path.basename(self.path)
            self.extension = os.path.splitext(self.path)[1]
            logging.info("Created non-empty picture object.")

    def getSize(self):
        if(self.path == const.DEFAULT_PATH): raise exception.EmptyPicture
        else:
            return os.stat(self.path).st_size

    def getPath(self):
        return self.path

    def getName(self):
        return self.name

    def setName(self, newName):
        if newName == None: raise exception.EmptyArgument
        if not newName.endswith(const.SUPPORTED_EXTENSIONS): raise exception.InvalidExtension

        oldName = self.name

        #self.path = os.rename(self.name, newName)
        self.name = newName
        self.path = os.path.dirname(self.path) + newName
        self.extension = os.path.splitext(self.path)[1]
        
        logging.info(f'Changed picture name from {oldName} to {newName}');

    def __str__(self):
        return f'[PICTURE OBJECT] Name: {self.name}, Path: {self.path}, Extension: {self.extension}, Description: "{self.description}"'
    




