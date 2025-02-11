USE [master]
GO

/****** Object:  Database [dbGolfathon_Final]    Script Date: 1/4/2025 12:19:56 AM ******/
CREATE DATABASE [dbGolfathon_Final]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'dbGolfathon_Final', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\dbGolfathon_Final.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'dbGolfathon_Final_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\dbGolfathon_Final_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
 WITH CATALOG_COLLATION = DATABASE_DEFAULT
GO

IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [dbGolfathon_Final].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO

ALTER DATABASE [dbGolfathon_Final] SET ANSI_NULL_DEFAULT OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET ANSI_NULLS OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET ANSI_PADDING OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET ANSI_WARNINGS OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET ARITHABORT OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET AUTO_CLOSE OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET AUTO_SHRINK OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET AUTO_UPDATE_STATISTICS ON 
GO

ALTER DATABASE [dbGolfathon_Final] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET CURSOR_DEFAULT  GLOBAL 
GO

ALTER DATABASE [dbGolfathon_Final] SET CONCAT_NULL_YIELDS_NULL OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET NUMERIC_ROUNDABORT OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET QUOTED_IDENTIFIER OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET RECURSIVE_TRIGGERS OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET  DISABLE_BROKER 
GO

ALTER DATABASE [dbGolfathon_Final] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET TRUSTWORTHY OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET PARAMETERIZATION SIMPLE 
GO

ALTER DATABASE [dbGolfathon_Final] SET READ_COMMITTED_SNAPSHOT OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET HONOR_BROKER_PRIORITY OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET RECOVERY FULL 
GO

ALTER DATABASE [dbGolfathon_Final] SET  MULTI_USER 
GO

ALTER DATABASE [dbGolfathon_Final] SET PAGE_VERIFY CHECKSUM  
GO

ALTER DATABASE [dbGolfathon_Final] SET DB_CHAINING OFF 
GO

ALTER DATABASE [dbGolfathon_Final] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO

ALTER DATABASE [dbGolfathon_Final] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO

ALTER DATABASE [dbGolfathon_Final] SET DELAYED_DURABILITY = DISABLED 
GO

ALTER DATABASE [dbGolfathon_Final] SET ACCELERATED_DATABASE_RECOVERY = OFF  
GO

ALTER DATABASE [dbGolfathon_Final] SET QUERY_STORE = OFF
GO

ALTER DATABASE [dbGolfathon_Final] SET  READ_WRITE 
GO

