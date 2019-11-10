# Story 1
**As a** parent  
**I want** to know the marks of my child    
**So that** I can monitor his/her performance  

# Use case for Story 1
**Use case**: show marks of parent's child  
**Scope**: student record management  
**Level**: user-goal  
**Intention in context**: the parent wants to know the marks of his child  
**Primary actor**: parent  

**Stakeholders' interests**:
* the parent wants to see the performance of his child
* the teacher wants the marks he/she has assigned to be available to parents

**Precondition**: child and parent are registered in the system and associated to each other

**Success Guarantees**: parent can see the marks of the child

**Main success scenario**:
1. Parent provides authentication information
2. System verifies the credentials and shows associated childs
3. Parent select child
4. System show child's marks  

The use case terminates with success

**Extensions**:  
1a. parent enters wrong credentials and authentication fails: the use case terminates with a failure  
2a. parent has no child associated: the system shows a warning message  
3a. parent selects filter to show marks for a certain class/time period
  
