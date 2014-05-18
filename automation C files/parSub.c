/******
 *
 *  asbb.c 
 *  Robert Clark, ebobtron
 *  
 *   CS50x  winter/spring 2014 with launchcode
 *  
 *  automate the testing and posting of submissions to the Leader Board
 *
 ******/
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdbool.h>
#include <unistd.h>

#include "hidden.h"

int main(void) {

    char stringBuf[550];
    char lowBuf[550];
    char id[255];
    char oldid[255];
    oldid[0] = '\0';
    char name[255];
    char ttime[255];
    char oldttime[255];
    
    FILE* infile = fopen("submis.txt","r");
    if(!infile) {
        printf("\n....    nothing to crunch sending notifications");
        goto SEND;
    }
       
    FILE* outfile = fopen("newsubdata.txt", "w");
    
    while(true) {
        
        fgets(stringBuf,sizeof(stringBuf),infile);
        sscanf(stringBuf,"%[^,],%[^,],%[^,],", id, name, ttime);
        
        if(atoi(id) == atoi(oldid)) {
            
            if(atof(oldttime) > atof(ttime)) {
                
                strcpy(lowBuf, stringBuf);
                strcpy(oldttime, ttime);
            }
            
        }
        else {
            
            if(atoi(oldid)) {
                
                fprintf(outfile, "%s", lowBuf);
            }
            
            strcpy(lowBuf, stringBuf);
            strcpy(oldid, id);
            strcpy(oldttime, ttime);            
        }   
            
        if(feof(infile)) {
            break;
        }
        
    }
    
    fprintf(outfile,  "%s", lowBuf);

    if(infile) {
        fclose(infile);
    }
    if(outfile) {
        fclose(outfile);
    }

    printf("/n....    selection of best times complete\n");
    
    // jump or goto point, for notifacations without valid submissions.
    SEND:;
    sleep(2);
    
    printf("\n....    sending new submission info to server\n");
    
    sprintf(name,"./ftp.sh %i", PWRD);
    system(name);
    sleep(2);

    printf("\n....    invoking webpage update.php\n");
    
    system("xdg-open http://speller-leaderboard.freehostia.com/public/update.php?data=yes");
    sleep(2);
    
    printf("\n....    invoking webpage \n");
    
    system("xdg-open http://speller-leaderboard.freehostia.com");
    sleep(2);
    
    printf("\n....    job complete :)  \n");
    
    return 0;
}


