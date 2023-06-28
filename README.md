# Labsys Portal

## Application Portal Page

#### Provides a page with links for various internal applications.  Also provides functionality for user authentication (login) and password resetting.

### Build:
1. Run python build.py
2. This creates a dist/labsys_portal.zip

### Deploy
1. Copy dist/labsys_portal.zip to the hosting root dir.
    * E.g. dist/labsys_portal.zip -> applive:/var/ww/html/
3. Perform deploy by unzipping files in situ.
    * E.g. unzip labsys_portal.zip
