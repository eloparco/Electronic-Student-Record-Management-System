# Story 2
**As a** teacher  
**I want** to record the daily lecture topics   
**So that** I can inform parents and students and have an official recording for institutional purposes 

# Use case for Story 1
**Use case**: record daily lecture topics  
**Scope**: student record management  
**Level**: user-goal  
**Intention in context**: the teacher wants to inform parents, students and school system about the topics covered in class
**Primary actor**: teacher 

**Stakeholders' interests**:

* the teacher wants to record the lecture topics to be available to parents and school system
* the parent wants to know the topics covered daily by a teacher

**Precondition**: teacher is registered in the system and the child is connected to the right class

**Success Guarantees**: daily lecture topics are record and visible to child's parents

**Main success scenario**:

1. Teacher provides credentials for authentication
2. System verifies the credentials and shows teacher's classes
3. Teacher selects class and date and enters lecture title and description
4. System shows the topics of the day

The use case terminates with success

**Extensions**:  
1a. teacher enters wrong credentials and authentication fails: the use case terminates with a failure   
2a. teacher selects a wrong class: the system provides a way to be able to cancel the operation and go back  
3a. text entered by the teacher to describe a topic is too long: the systems shows a warning message  
