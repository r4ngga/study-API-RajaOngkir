<!DOCTYPE html>
<html lang="EN">

<head>
    <meta charset="UTF-8">
    <title>Belajar Api Raja Ongkir</title>
    <link rel="icon" type="image/icon" sizes="16x16" href="assets/images/favicon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
</head>

<body>
    <br>
    <div class="container mb-4">
        <img src="assets/images/rajaongkirlogo.png" alt="logo">
        <br><br><br>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cek Ongkos Kirim</h3>
                    </div>
                    <div class="panel-body">
                        <div>
                            <?php
                            //Get Data Kabupaten
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => "http://api.rajaongkir.com/starter/city",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "GET",
                                CURLOPT_HTTPHEADER => array(
                                    "key:API key"
                                ),
                            ));

                            $response = curl_exec($curl);
                            $err = curl_error($curl);

                            curl_close($curl);
                            echo "
                            <div class= \"form-group\">
                            <label for=\"asal\">Kota/Kabupaten Asal </label>
                            <select class=\"form-control\" name='asal' id='asal'>";
                            echo "<option>Pilih Kota Asal</option>";
                            $data = json_decode($response, true);
                            for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
                                echo "<option value='" . $data['rajaongkir']['results'][$i]['city_id'] . "'>" . $data['rajaongkir']['results'][$i]['city_name'] . "</option>";
                            }
                            echo "</select>
                            </div>";
                            //Get Data Kabupaten
                            //

                            //Get Data Provinsi
                            $curl = curl_init();

                            curl_setopt_array($curl, array(
                                CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "GET",
                                CURLOPT_HTTPHEADER => array(
                                    "key:API key"
                                ),
                            ));

                            $response = curl_exec($curl);
                            $err = curl_error($curl);

                            echo "
                            <div class= \"form-group\">
                            <label for=\"provinsi\">Provinsi Tujuan </label>
                            <select class=\"form-control\" name='provinsi' id='provinsi'>";
                            echo "<option>Pilih Provinsi Tujuan</option>";
                            $data = json_decode($response, true);
                            for ($i = 0; $i < count($data['rajaongkir']['results']); $i++) {
                                echo "<option value='" . $data['rajaongkir']['results'][$i]['province_id'] . "'>" . $data['rajaongkir']['results'][$i]['province'] . "</option>";
                            }
                            echo "</select>
                            </div>";
                            //
                            ?>

                            <div class="form-group">
                                <label for="kabupaten">Kota/Kabupaten Tujuan</label><br>
                                <select class="form-control" id="kabupaten" name="kabupaten"></select>
                            </div>
                            <div class="form-group">
                                <label for="kurir">Kurir</label><br>
                                <select class="form-control" id="kurir" name="kurir">
                                    <option value="jne">JNE</option>
                                    <option value="tiki">TIKI</option>
                                    <option value="pos">POS INDONESIA</option>
                                    <option value="esl">Eka Sari Lorena</option>
                                    <option value="rpx">RPX Holding</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="berat">Berat (gram)</label><br>
                                <input class="form-control" id="berat" type="text" name="berat" value="100" />
                            </div>
                            <button class="btn btn-success" id="cek" type="submit" name="button">Cek Ongkir</button>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Hasil</h3>
                    </div>
                    <div class="panel-body">
                        <ol>
                            <div id="ongkir"></div>
                    </div>
                    </ol>
                </div>
            </div>
        </div>

    </div>
    </div>
</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {
        $('#provinsi').change(function() {
            var prov = $('#provinsi').val();

            $.ajax({
                type: 'GET',
                url: 'http://localhost/belajar_api_rajaongkir/cek_kabupaten.php',
                data: 'prov_id=' + prov,
                success: function(data) {
                    $("#kabupaten").html(data);
                }
            });
        });

        $("#cek").click(function() {
            var asal = $('#asal').val();
            var kab = $('#kabupaten').val();
            var kurir = $('#kurir').val();
            var berat = $('#berat').val();

            $.ajax({
                type: 'POST',
                url: 'http://localhost/belajar_api_rajaongkir/cek_ongkir.php',
                data: {
                    'kab_id': kab,
                    'kurir': kurir,
                    'asal': asal,
                    'berat': berat
                },
                success: function(data) {
                    $("#ongkir").html(data);
                }
            });
        });
    });
</script>
