/**
 *
 *  asbb.c 
 *  Robert Clark, ebobtron
 *  
 *   CS50x  winter/spring 2014 with launchcode
 *  
 *  automate the testing and posting of submissions to the Leader Board
 *
 ***********************************************************************/
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdbool.h>
#include <unistd.h>

#include "hidden.h"

int main(void) {

    // define some strings or character buffers
    char stringBuf[550];
    char lowBuf[550];
    char id[255];
    char oldname[255];
    char name[255];
    char ttime[255];
    char oldttime[255];
    
    // initialize a string to null
    oldname[0] = '\0';
    
    // open benchmark results
    FILE* infile = fopen("submis.txt","r");
    
    // if benchmark file open for reading 
    if(infile) {
           
        // open the output file
        FILE* outfile = fopen("newsubdata.txt", "w");
        
        while(true) {
            
            // buffer a line a data from the benchmark file
            fgets(stringBuf,sizeof(stringBuf),infile);
            
            // colect the first three strings from the CSV file
            sscanf(stringBuf,"%[^,],%[^,],%[^,],", id, name, ttime);
            
            if(!strcmp(name,oldname)) {
                
                if(atof(oldttime) > atof(ttime)) {
                    
                    strcpy(lowBuf, stringBuf);
                    strcpy(oldttime, ttime);
                }
            }
            else {
                
                if(oldname[0]) {
                    
                    fprintf(outfile, "%s", lowBuf);
                }
                
                strcpy(lowBuf, stringBuf);
                strcpy(oldname, name);
                strcpy(oldttime, ttime);            
            }   
                
            if(feof(infile)) {
                break;
            }
        }
        
        fprintf(outfile,  "%s", lowBuf);

        // close files
        if(outfile) {
            fclose(outfile);
        }

        printf("\n\n....    selection of best times complete\n");
        
    }
    else
    {
        // infile==NULL; for notifications without valid submissions.
        printf("\n....    nothing to crunch; sending notifications");
    }
    
    if(infile) {    
        fclose(infile);
    }
    
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


