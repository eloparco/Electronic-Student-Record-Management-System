# Story 5
**As an** administrative officer  
**I want** to enter class composition   

# Use case for Story 5
**Use case**: enter class composition  
**Scope**: student record management  
**Level**: user-goal  
**Intention in context**: the administrative officer wants to assign students to diffent classes  
**Primary actor**: administrative officer  

**Stakeholders' interests**:
* the administrative officer wants to distribute students in classes to make balance classes
* the student wants to be placed in a class
* the parent wants his child to be placed in a good class

**Precondition**: students must exist in the system, the maximum number of students per class is not already reached

**Success Guarantees**: class composition is done and has between 15 and 30 students

**Main success scenario**: 
1. Administrative officer provides authentication information  
2. System verifies the credentials and shows possible options  
3. Administrative officer selects "enter class composition"  
4. System shows the list of students not already assigned to a class  
5. Administrative officer selects the students and assigns a class  

The use case terminates with success

**Extensions**:  
1a. Administrative officer enters wrong credentials and authentication fails: the use case terminates in failure  
3a. Administrative officer selects another option: the use case is not finished   
5a. The class is already full: an error message is showed and the use case terminates in failure 
  
