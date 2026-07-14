$headerPath = "c:\xampp\htdocs\bbvision\headerr.php"
$content = Get-Content -Raw -Path $headerPath
$newContent = $content -ireplace "qvision/", "qvision/"
Set-Content -Path $headerPath -Value $newContent -Encoding UTF8
Write-Output "Replacement complete."
