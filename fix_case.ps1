$base = 'c:\xampp\htdocs\bbvision'
$files = Get-ChildItem -Path $base -Recurse -Filter '*.php'
$map = @{}
foreach ($f in $files) {
    # Get relative path and convert backslashes to forward slashes
    $rel = $f.FullName.Substring($base.Length + 1).Replace('\', '/')
    $map[$rel.ToLower()] = $rel
}

$headerPath = "$base\headerr.php"
$content = Get-Content -Raw -Path $headerPath

# We will match anything that looks like a relative path ending in .php
# inside href="..." or url: "..." or similar.
# A simpler approach: use a regex evaluator for any string ending in .php
$pattern = '(?i)(?:href=["'']|url:\s*["''])([^"'']+\.php)(?=["''])'

$newContent = [regex]::Replace($content, $pattern, {
    param($match)
    $fullMatch = $match.Groups[0].Value
    $val = $match.Groups[1].Value
    $lower = $val.ToLower()
    
    if ($map.ContainsKey($lower)) {
        $realCase = $map[$lower]
        # return the full matched string but with the value replaced by realCase
        return $fullMatch.Replace($val, $realCase)
    } else {
        return $fullMatch
    }
})

Set-Content -Path $headerPath -Value $newContent -Encoding UTF8
Write-Output "Case correction complete."
