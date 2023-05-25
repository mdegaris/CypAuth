$FileName = "dist\labsys_portal.zip"
if (Test-Path $FileName) {
  Remove-Item $FileName
}
Compress-Archive -Path "public" -DestinationPath $FileName -Force