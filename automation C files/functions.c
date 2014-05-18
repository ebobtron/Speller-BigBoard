/******
 *
 *  functions.c 
 *  Robert Clark, ebobtron
 *  
 *  CS50x  winter/spring 2014 with launchcode
 *  
 *  functions to help asbb.c
 *  automate the testing and posting of submissions to the Leader Board
 *
 ******/

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdbool.h>

#include "functions.h"



int splash(void) {

    printf("\033[2J\033[1;0H");
    char* a = "\n\n....    asbb \" auto speller big board \" version: 1.00\n";
    char* b = "        automatic leader board submission management\n";
    char* c = "        by Robert Clark, aka ebobtron  final project CS50x\n";
    char* d = "        winter / spring 2014 with Launch Code\n";
    printf("%s%s%s%s", a, b, c,d);
    
    return 0;
}

/*  
int createConfig(void) {

    FILE* outfile = fopen("config.txt","w");
    
    fprintf(outfile, "dir_prefix=downloaded\n");      *****/
    //fprintf(outfile, "input=ftp://XXXXXX.freehostia.com:21/speller-leaderboard.freehostia.com/uploading/*\n");
    /*
    fprintf(outfile, "login=XXXXXXX\n");
    fprintf(outfile, "password=XXXXXXX\n");
    // /ftp.avsfilmcutter.com:21/
    if(outfile)
        fclose(outfile);
    
    return 0;
}*/


int checkDownloaded(void) {

    // collect file names from downloaded
    switch(glob("downloaded/*.x", 0, NULL, &SUBDATA)) {
      case 0:
            break;
      case GLOB_NOSPACE:
            printf( "Out of memory\n" );
            return 1;
      case GLOB_ABORTED:
            printf( "Reading error\n" );
            return 1;
      case GLOB_NOMATCH:
            printf( "\033[1A....    No submission files found.\n\n" );
            
            // clean up
            system("rm -f downloaded/*");
            system("rmdir downloaded");
            if(&SUBDATA)
                globfree(&SUBDATA);
            return 1;
            break;
      default:
            break;
    }
    
    return 0;
}    


bool parseVal(void)
{
    
    float memory = 0;
    
    char word[15][20];
    for(int i = 0; i < 15; i++) {    
        word[i][0] = '\0';
    } 
   
    FILE* infile =  fopen("vdump.txt","r");
    fgets(valResults,sizeof(valResults),infile);

    while(!feof(infile)) {
        sscanf(valResults,"%s%s%s%s%s%s%s%s%s",
                  word[0],word[1],word[2],word[3],word[4],word[5],word[6],word[7],word[8]);
        if(word[8][0]) {           
            // get leak
            if(!strcmp(word[7],"in")) {            
                if(strcmp(word[8],"0")) {
                    valResults[strlen(valResults) - 1] = '\0';
                    return false;
                } 
            }
            // get the memory used on heap
            if(!strcmp(word[7],"frees,")) {
                memory = (float) stringToInt(word[8]) / 1048576;
            }
        }
        fgets(valResults,sizeof(valResults),infile);
    }
    
    if(infile)
        fclose(infile);
        
    system("rm -f vdump.txt");
    
    if(word[3][0] == '0') {
        sprintf(valMemory,"%f",memory);
        sprintf(valResults, "memory = %f", memory);
        return true;
    }
    valResults[strlen(valResults) - 1] = '\0';
    return false;
}

int stringToInt(char* string)
{
    char tWord[strlen(string)];
    for(int i = 0, j = 0; i < strlen(string); i++) {
        
        if(string[i] != ',') {
            
            tWord[j] = string[i];
            j++;
        }
    }
    return atoi(tWord);
}

bool spelling(void){

    bool spell = false;
    bool dictionary = false;
    bool wordcount = false;
    char word[8][15];
    char line[150];
    
    FILE* infile = fopen("sresults.txt","r");
    fseek(infile, -224, SEEK_END);
    
    while(!feof(infile)) {
        sscanf(line,"%s%s%s%s%s", word[0], word[1], word[2], word[3], word[4]);
        
        if(!strcmp(word[1], "MISSPELLED:")) {
            if(!strcmp(word[2], "2415")) {
                spell = true;
            }
        }
        if(!strcmp(word[2], "DICTIONARY:")) {
            if(!strcmp(word[3], "143091")) {
                dictionary = true;
            }
        }    
        if(!strcmp(word[2], "TEXT:")) {
            if(!strcmp(word[3], "163834")) {
                wordcount = true;
            }
        }
        
        fgets(line, sizeof(line), infile);
    }
    if(infile)
        fclose(infile);
        
    if(wordcount && dictionary && spell) {
        sprintf(spellerResults, "can spell");
        return true;
    }
    else {
        sprintf(spellerResults, "failed one or more -> spelling: %i dictionary: %i word count: %i",
                                spell, dictionary, wordcount);
        return false;
    }
    return false;

}

/*
int subName(char* name, char* file) {
    
    char* path = "downloaded/";
    char fname[100];
    
    short int fcount = 0;
    for(int j = strlen(path); j < strlen(file); j++)
    {
       fname[fcount] = file[j];
       fname[fcount+1] ='\0';
       fcount++;
    }  
    fname[strlen(fname) - strlen("speller.x")] = '\0';
    //printf( "%s  %s\n", file , fname );
    strcpy(name, fname);
    
    return 0;
}             **************/


/*
int generateEmailNotifications() {

    printf("......   GENERATING EMAIL NOTIFICATIONS   .......");

    
    char name[255];
    char id[6];
    char email[255];
    
    FILE* outfile = fopen("email.txt", "w");
    
    FILE* infileInfo = fopen("downloaded/subInfo.txt","r");

   
    
    
    

    return 0;
}*/ 




