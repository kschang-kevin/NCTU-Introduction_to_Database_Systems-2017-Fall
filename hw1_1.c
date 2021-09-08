#include <stdio.h>
#include <unistd.h>
#include <sys/types.h>
#include<string.h>
#include <sys/wait.h> 
#define MAX_LINE 80
void read_input(char inputBuffer[], char *arg[], int *background,int *should_run)
{
	int length,i;
	int ct=0;
	int start=-1;
	length=read(STDIN_FILENO, inputBuffer, MAX_LINE);
	if(inputBuffer[0]=='e')
	{
		*should_run=0;
	}
	for(i=0;i<length;i++) 
	{
		switch (inputBuffer[i]) 
		{
			case ' ':
			case '\t': /* argument separators */
				if (start != -1) 
				{
					arg[ct] = &inputBuffer[start]; /* set up pointer */
					ct++;
				}
				inputBuffer[i] = '\0'; /* add a null char; make a C string */
				start = -1;
				break;
				
			case '\n': /* should be the final char examined */
				if (start != -1) 
				{
					arg[ct] = &inputBuffer[start];
					ct++;
				}
				inputBuffer[i] = '\0';
				arg[ct] = NULL; /* no more arguments to this command */
				break; 
			case '&':
				*background = 1;
				inputBuffer[i] = '\0';
				break;
				
			default: /* some other character */
				if (start == -1) {
					start = i;
				}
		}
}
}
int main(void)
{
	int i;
	int background;
	int status=0;
	int length;
	char inputBuffer[MAX_LINE];
	char *arg[MAX_LINE/2+1]; /*command line arguments*/
	int should_run=1; /*flag to determine when to exit program*/
	while(should_run)
	{
		background=0;
		pid_t pid;
		printf("osh>");
		fflush(stdout);
		read_input(inputBuffer, arg ,&background,&should_run);
		fflush(stdout);
		pid=fork();
		if(pid==0)
		{
			execvp(*arg,arg);
		}
		if(background==0&&pid!=0)
		{			
			wait(&pid);
		}
			
		/**
		* your code!
		* After reading user input, the step are:
		* (1) fork a child process using fork()
		* (2) the child process will invoke execvp()
		* (3) if command included &, parent will invoke wait()
		*/
	}
	
	return 0;
}

