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


#include "functions.h"

// some globals
unsigned short int MYSTRINGSIZE = 255;
unsigned short int MYIDSIZE = 4;

int main(int argc, char* argv[])
{
    // variable and structure defines
    char stringBuf[255];

    // TODO remove
    //char nameBuf[50];   
    
    
    // splash the screen start the program
    splash();
    sleep(1);
    
    // we need a download folder 
    while(glob("downloaded", 0, NULL, &SUBDATA)) {
    
        printf("\n....    download directory not found\n" );
        sleep(2);
        printf("\33[1A....    making directory \" download \"\n");
        sleep(1);
        system("mkdir downloaded");
    }
    
    // create command string for wget   
    sprintf(stringBuf,"wget -a wgetlog.txt -v --config=config.txt");
   
    // security exclusion.
    // create config file for wget
    // createConfig();

    // download submission files
    int result = system(stringBuf);    

    // remove config.txt to safeguard security data
    // system("rm -f config.txt");
    
    // display ftp errors if any and close
    if(!result) {
    
        printf("\n....    Download Attempt Completed\n");
    }    
    else {
    
        printf("SYSTEM ERROR CODE = %i, consult documention.\n", result);
        
        // clean up and go
        system("rm -f downloaded/*");
        system("rmdir downloaded");    
                                                           
        if(&SUBDATA)
            globfree(&SUBDATA);
        
        return 1;
    }
    
    sleep(2);
    
    checkDownloaded();
    
    char file[SUBDATA.gl_pathc][MYSTRINGSIZE + 1];
    char id[SUBDATA.gl_pathc][MYIDSIZE + 1];
    char name[SUBDATA.gl_pathc][MYSTRINGSIZE + 1];
    char email[SUBDATA.gl_pathc][MYSTRINGSIZE + 1];
    
    char sbuf[256];
    int subcount = 0;
    
    FILE* infile = fopen("downloaded/subInfo.txt","r");
    fgets(sbuf ,sizeof(sbuf), infile);
    for(int i = 0; !feof(infile);i++) {
        
        //reference use %[^,], for csv files
        
        sscanf(sbuf,"%[^,],%[^,],%[^,],%[^,]", file[i], id[i], name[i], email[i]);
        email[i][strlen(email[i]) - 1] = '\0';
        
        printf("....    Submission Id: %s  Name: %s  \n", id[i], name[i]);
        
        subcount ++;
        
        fgets(sbuf ,sizeof(sbuf), infile);
    
    }
    
    fclose(infile);
    if(SUBDATA.gl_pathc == subcount) {
    
    
        // set submission file permissions
        system("chmod 711 downloaded/*");
    }
    else {
        printf("    **** WARNING ** file count does not match recorded submissions  ***\n");
        printf("        .x files = %i Submission Text = %i\n", SUBDATA.gl_pathc, subcount);
        return 1;
    }
    
    /*/clean up
       system("rmdir downloaded");                                              
       if(&SUBDATA)
           globfree(&SUBDATA);
    
       return 2;               **********/

    
    if(SUBDATA.gl_pathc) {
        
        printf("\n....    Starting memory error and leak test with Valgrind\n");
    }
    
    for(int i = 0; i < SUBDATA.gl_pathc; i++) {
        
        // get submission name  TODO  remove
        //subName(nameBuf, SUBDATA.gl_pathv[i]);
        
        // create valgrind command string
        sprintf(stringBuf,"valgrind --log-file=vdump.txt ./downloaded/%s \
                       dracula.txt > sresults.txt", file[i]);
        // run valgrind
        system(stringBuf);

        // add a pretty
        printf("\n");
        
        // open output files 
        FILE* outfilePass = fopen("pass.txt","a");
        FILE* outfileFail = fopen("fail.txt","a");
        FILE* outfileNote = fopen("emailNot.txt", "a");

        // temporary file handle holder
        FILE* outfile = NULL;
                
        
        // parse the valgrind dump for erorrs and memory usage
        // then print and store results of test
        if(parseVal()) {            
            
            printf("        %s passed Valgrind testing -> reports %s\n", id[i], valResults);
            
            sprintf(stringBuf, "%s, %s\n", name[i], valResults);
            fwrite(stringBuf, strlen(stringBuf), 1, outfilePass);
            
            outfile = outfilePass;
            if(outfileFail) {
                fclose(outfileFail);
            }
        }
        else {
            printf("        %s failed Valgrind testing reports %s\n", id[i], valResults);
            sprintf(stringBuf, "%s, failed valgrind: %s \n", name[i], valResults);
            fwrite(stringBuf, strlen(stringBuf), 1, outfileFail);
            outfile = outfileFail;
            
            if(outfilePass) {
                fclose(outfilePass);
            }
        }

        if(spelling()) {
            sprintf(stringBuf, "        %s -> %s\n", id[i], spellerResults);
            printf("%s", stringBuf);
            fwrite(stringBuf, strlen(stringBuf), 1, outfile);  
            }
            else {
                sprintf(stringBuf, "        %s -> %s\n", id[i], spellerResults);
                printf("%s", stringBuf);
                fwrite(stringBuf, strlen(stringBuf), 1, outfile);  
            }

        if(outfile == outfilePass) {
            
            fprintf(outfileNote,"%s,%s,%s\n",email[i], "from", "Leader Board");
            fprintf(outfileNote,"  %s, id: %s, %s\n", name[i], id[i], \
                        "Welcome to the Leader Board,");
            
            }
            else {
            
            fprintf(outfileNote,"%s,%s,%s\n",email[i], "from", "Leader Board");
            fprintf(outfileNote,"%s - %s -%s\n", \
               "Sorry, your submission failed valgind and/or a spelling check", \
                valResults, spellerResults);
            }
            
        
        
        if(outfile) {
            fclose(outfile);
            }
        if(outfileNote) {
            fclose(outfileNote);
            }    
        
        
        // TODO cleanup dump result files for next test.
    }
    
     // remove files and downloaded directory
    system("rm -f downloaded/*");
    system("rmdir downloaded");
                                                           
    if(&SUBDATA)
        globfree(&SUBDATA);
    
    //
    //generateEmailNotifications();                                          
    printf("\n....    done, bye!\n\n");
    return 0;
    
}



