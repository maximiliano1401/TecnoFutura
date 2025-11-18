# Script para centrar modelos 3D en el origen (0,0,0)

# Función para centrar un modelo OBJ
function Center-OBJModel {
    param(
        [string]$InputFile,
        [string]$OutputFile,
        [double]$OffsetX,
        [double]$OffsetY,
        [double]$OffsetZ
    )
    
    Write-Host "Procesando: $InputFile"
    Write-Host "Offset: X=$OffsetX, Y=$OffsetY, Z=$OffsetZ"
    
    $content = Get-Content $InputFile
    $newContent = @()
    
    foreach ($line in $content) {
        if ($line -match "^v\s+") {
            # Es una línea de vértice
            $parts = $line -split "\s+"
            $x = [double]$parts[1] - $OffsetX
            $y = [double]$parts[2] - $OffsetY
            $z = [double]$parts[3] - $OffsetZ
            
            $newLine = "v $x $y $z"
            $newContent += $newLine
        } else {
            # Mantener la línea sin cambios
            $newContent += $line
        }
    }
    
    # Guardar el archivo
    $newContent | Set-Content $OutputFile -Encoding UTF8
    Write-Host "Guardado: $OutputFile`n"
}

# Centrar LAPTOP1
$laptop1Path = "laptop1\lap1.obj"
$laptop1Backup = "laptop1\lap1_original.obj"
$laptop1Center = @{X = 47.0; Y = 1.129977264975; Z = -87.01}

# Hacer backup
Copy-Item $laptop1Path $laptop1Backup -Force
Write-Host "Backup creado: $laptop1Backup"

# Centrar modelo
Center-OBJModel -InputFile $laptop1Backup -OutputFile $laptop1Path `
    -OffsetX $laptop1Center.X -OffsetY $laptop1Center.Y -OffsetZ $laptop1Center.Z

# Centrar MONITOR1
$monitor1Path = "monitor_1\monitor1.obj"
$monitor1Backup = "monitor_1\monitor1_original.obj"
$monitor1Center = @{X = -35.0193; Y = 63.47565; Z = -71.4498}

Copy-Item $monitor1Path $monitor1Backup -Force
Write-Host "Backup creado: $monitor1Backup"

Center-OBJModel -InputFile $monitor1Backup -OutputFile $monitor1Path `
    -OffsetX $monitor1Center.X -OffsetY $monitor1Center.Y -OffsetZ $monitor1Center.Z

# Centrar MONITOR2
$monitor2Path = "monitor_2\monitor2.obj"
$monitor2Backup = "monitor_2\monitor2_original.obj"
$monitor2Center = @{X = -42.82625; Y = 52.70595; Z = -128.0105}

Copy-Item $monitor2Path $monitor2Backup -Force
Write-Host "Backup creado: $monitor2Backup"

Center-OBJModel -InputFile $monitor2Backup -OutputFile $monitor2Path `
    -OffsetX $monitor2Center.X -OffsetY $monitor2Center.Y -OffsetZ $monitor2Center.Z

Write-Host "====================================="
Write-Host "PROCESO COMPLETADO"
Write-Host "====================================="
Write-Host "Los modelos han sido centrados en el origen (0,0,0)"
Write-Host "Los archivos originales se guardaron con sufijo '_original'"
