# Story 3
**As an** administrative officer
**I want** to enable access to parents

# Use case for Story 3
**Use Case**: enable access to parents  
**Scope**: student record management  
**Level**: user-goal  
**Intention in context**: administrative officer wants to control the parents who can access the system
**Primary actor**: administrative actor  

**Stakeholders' interests**:
* the administrative officer wants to give access to parents
* the parent wants to be enable to use the system

**Precondition**: anything

**Main success scenario**: 
1. Administrative officer provide authentication information
2. System verifies the credentials and shows possible options
3. Administrative officer selects "enable access to parents"
4. System shows all parents how want to have access to the system
5. Administrative officer selects a parent and give access to him
The use case terminates with success

**Extensions**:
1a. Administrative officer enters wrong credentials and authentication fails: the use case terminates in failure

3a. Administrative officer selects another option: the use case is not finished 

4a. There are not any parents who want access to the system: the use case terminates in failure

 
