# docker 
docker exec -it sqlserver2019 /opt/mssql-tools/bin/sqlcmd -S localhost -U sa -P N10m@ds2021!

# QUERYS
Create User dev1 with Password MyPass
USE [master]
GO
CREATE LOGIN [dev1] WITH PASSWORD=N'MyPass' MUST_CHANGE, 
DEFAULT_DATABASE=[master], CHECK_EXPIRATION=ON, CHECK_POLICY=ON
GO

Assign Roles to the User
USE [AdventureWorks]
GO
CREATE USER [dev1] FOR LOGIN [dev1]
GO

db_owner ROLE
USE ContainedDatabase;
GO
ALTER ROLE db_owner ADD MEMBER [username];