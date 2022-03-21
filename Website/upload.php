<!DOCTYPE html>
<html lang="hu">
<head>
    <?php include('components/head.php'); ?>
    <link rel="stylesheet" href="./designs/users.css">
    <link rel="stylesheet" href="./designs/upload.css">
    <script src="./javascript/users.js"></script>
    <script src="./javascript/upload.js"></script>
</head>
<?php include('components/navbar.php'); ?>
<body>
<div class="card" style="margin-top: 40px;margin-left: auto;margin-right:auto;width: 95%">
    <h1><i class="fas fa-upload"></i> Kép Feltöltés</h1>
    <hr>

    <div class="row">
        <div class="col" style="vertical-align: top;">
            <div class="form-outline form-white mb-4">
                <input type="username" id="clid" name="clid" class="form-control form-control-lg"/>
                <label class="form-label" for="clid">Nem regisztrált fehasználó azonosítója </label>
            </div>
            <label class="form-label">TeamSpeak 3 Képernyő Kép</label>
            <div class="form-outline form-white mb-4">
                <label class="btn btn-outline-light btn-xlg px-5">
                    <input type="file" id="file" accept="image/*" onchange="loadFile(event,'placeholder')" name="file"/>
                    Kép kiválasztása
                </label>
                <button class="btn btn-outline-light btn-xlg px-5" style="vertical-align: center" onclick="removeFile(event,'placeholder')">Kép törlése</button>
            </div>
            <label class="form-label">User Control Panel képernyő Kép (Nem kötelező)</label>
            <div class="form-outline form-white mb-4">
                <label class="btn btn-outline-light btn-xlg px-5">
                    <input type="file" id="file2" accept="image/*" onchange="loadFile(event,'placeholder2')" name="file"/>
                    Kép kiválasztása
                </label>
                <button class="btn btn-outline-light btn-xlg px-5" style="vertical-align: center" onclick="removeFile(event,'placeholder2')">Kép törlése</button>
            </div>
            <button class="btn btn-outline-light btn-lg px-5" onclick="sendDatas()">Küldés</button>
        </div>

        <script>
            let loadFile = function(event,placeholder) {
                const output = document.getElementById(placeholder);
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    output.style.display = 'inline';
                    URL.revokeObjectURL(output.src)
                }
            };
            let removeFile = function(event,placeholder) {
                document.querySelector('[type=file]').value = null;
                document.getElementById(placeholder).style.display = 'none';
            };
        </script>

        <div class="col" style="vertical-align: top; float: right;">
            TeamSpeak Kép előnézete:
            <div class="form-outline form-white mb-4">

                <img src="" id="placeholder" style="display:none;width: 400px;height:400px;margin-top: 10px;object-fit: contain;";/>
            </div>
            UCP Kép előnézete:
            <div class="form-outline form-white mb-4">

                <img src="" id="placeholder2" style="display:none;width: 400px;height:400px;margin-top: 10px;object-fit: contain;";/>
            </div>
        </div>
    </div>
</div>






</body>
<?php include('components/footer.php'); ?>


