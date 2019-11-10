# Story 4
As an administrative officer
I want to enroll the students 

# Use case for Story 4
**Use Case**: enroll student  
**Scope**: student record management  
**Level**: user-goal  
**Intention in context**: the administrative officer wants to register new students in the system  
**Primary actor**: administrative officer  

**Stakeholders' interests**:
* the administrative officer wants to enroll students in the system and validate their data 

**Precondition**: the student must not exist previously in the system

**Main success scenario**: 
1. Administrative officer provides authentication information
2. System verifies the credentials and shows possible options
3. Administrative officer selects "enroll student"
4. System shows a form which has to be fill by the administrative officer with the student's data
5. Administrative officer fills the form
6. System validates the form and adds the new student to the system

The use case terminates with success

**Extensions**:  
1a. Administrative officer enters wrong credentials and authentication fails: the use case terminates in failure  
3a. Administrative officer selects another option: the use case is not finished  
6a. Validation fails because there are any blank in the form: administrative officer must fill them  
6b. Validation fails because student's fiscal code is already in the system: the use case terminates in failure  
  
