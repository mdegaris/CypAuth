import zipfile
import glob
import shutil
import os

def zipdir(path, ziph):
    # ziph is zipfile handle
    for root, dirs, files in os.walk(path):
        for file in files:
            print(file)
            ziph.write(os.path.join(root, file))

dist_zip = "labsys_portal.zip"
dist_folder = "dist"
build_folder = "labsys_portal"

zip_path = os.path.join(dist_folder, dist_zip)
folder_path = os.path.join(dist_folder, build_folder)

if os.path.exists(zip_path): os.remove(zip_path)
if os.path.exists(folder_path): shutil.rmtree(folder_path)
shutil.copytree("public", folder_path)

os.chdir(dist_folder)
with zipfile.ZipFile(dist_zip, 'w') as zip_handler:
    zipdir(build_folder, zip_handler)

if os.path.exists(build_folder): shutil.rmtree(build_folder)