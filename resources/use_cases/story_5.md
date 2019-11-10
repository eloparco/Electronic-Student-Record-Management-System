# Story 5
As an administrative officer  
I want to enter class composition   

# Use case for Story 5
**Use case**: enter class composition  
**Scope**: student record management  
**Level**: user-goal  
**Intention in context**: the administrative officer wants to assign students to diffent classes  
**Primary actor**: administrative officer  

**Stakeholders' interests**:
* the administrative officer wants to distribute students in classes to make balance classes

**Precondition**: students must exist in the system

**Main success scenario**: 
1. Administrative officer provide authentication information  
2. System verifies the credentials and shows possible options  
3. Administrative officer selects "enter class composition"  
4. Administrative officer selects available students  
5. Administrative officer selects a class 

The use case terminates with success

**Extensions**:  
1a. Administrative officer enters wrong credentials and authentication fails: the use case terminates in failure  
3a. Administrative officer selects another option: the use case is not finished   
5a. System validates the number of students in the class, and in case there are more than 30 students or less than 15, it shows an error and the class is not form: the use case terminates in failure 
  
