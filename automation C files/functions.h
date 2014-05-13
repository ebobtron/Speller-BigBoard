/******
 *
 *  functions.h
 * 
 *  Robert Clark, ebobtron
 *  
 *  CS50x  winter/spring 2014 with launchcode
 *  
 *  automate the testing and posting of submissions to the Leader Board
 *
 ******/

#include <glob.h>


/**
*  global variables
**************************/
char valMemory[12];
char valResults[256];
char spellerResults[256];

/**
*  global structure
*********************/
glob_t SUBDATA;

/**
*  functions prototypes
****************************/
int splash(void);
//int createConfig(void);
int checkDownloaded(void);
int stringToInt(char* string);
bool parseVal(void);
bool spelling(void);
//int subName(char* name, char* file);
//int generateEmailNotifications(void);

 
