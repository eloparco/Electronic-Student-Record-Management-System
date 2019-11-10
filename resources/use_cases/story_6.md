# Story 6
**As a** teacher  
**I want** assign a grade to a student  
**So that** I can keep track of the evaluation  

# Use case for Story 6
**Use Case**: assign grade  
**Scope**: student record management  
**Level**: user-goal  
**Intention in context**: teacher wants to give grades to students based on exams, homework...  
**Primary actor**: teacher

**Stakeholders' interests**:
* the teacher assigns grades to students based on their merits so could keep track on their work

**Precondition**:  student must be present and cannot repeating a score in the same day

**Success Guarantees**: a grade is assign to a student

**Main success scenario**: 
1. Teacher provides authentication information
2. System verifies the credentials and shows possible options
3. Teacher selects "assign grade"
4. System shows all students in the class
5. teacher selects a student
6. Teacher selects the grade the student should have

The use case terminates with success

**Extensions**:  
1a. Teacher enters wrong credentials and authentication fails: the use case terminates in failure   
3a. Teacher selects another option: the use case is not finished  
4a. There are not students presents, the teacher cannot assign any grade: the use case terminates in failure  
5a. Teacher selects the wrong student: the use case terminates in failure

