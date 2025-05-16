<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.8.11/tailwind.min.css"
      integrity="sha512-KO1h5ynYuqsFuEicc7DmOQc+S9m2xiCKYlC3zcZCSEw0RGDsxcMnppRaMZnb0DdzTDPaW22ID/gAGCZ9i+RT/w=="
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="../css/stylelogin.css" />
    <title>Register</title>
    <link rel="icon" href="../img/icon.svg" type="image/svg+xml" />
  </head>
  <body class="min-h-screen flex items-center justify-center px-4">
    <div
      class="fixed inset-0 bg-cover bg-center -z-10"
      id="background"
      style="background-image: url('uploads/bg.jpg');"
    ></div>

    <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-md relative z-10 ">
      <?php
        session_start();
        $msg = $_SESSION['msg'] ?? '';
        unset($_SESSION['msg']);
      ?>
      <h1 class="text-4xl font-bold text-green-500 text-center mb-8">Welcome to our community</h1>
      <?php if ($msg): ?>
        <div class="text-red-500 text-center mb-4"><?= $msg ?></div>
      <?php endif; ?>

      <form method="POST" action="registercode.php" class="space-y-6">
         <label for="region" class="block text-sm font-medium text-gray-700 mb-1">Select Region</label>
         <div class="flex items-center">
  <select id="region" class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm"  onchange="updateCities()">
    <option value="">-- Select a Region --</option>
    <option value="tanger-tetouan-alhoceima">Tanger-Tetouan-Al Hoceima</option>
    <option value="oriental">Oriental</option>
    <option value="fes-meknes">Fès-Meknès</option>
    <option value="rabat-sale-kenitra">Rabat-Salé-Kénitra</option>
    <option value="beni-mellal-khenifra">Béni Mellal-Khénifra</option>
    <option value="casablanca-settat">Casablanca-Settat</option>
    <option value="marrakech-safi">Marrakech-Safi</option>
    <option value="draa-tafilalet">Drâa-Tafilalet</option>
    <option value="souss-massa">Souss-Massa</option>
    <option value="guelmim-oued-noun">Guelmim-Oued Noun</option>
    <option value="laayoune-sakia-el-hamra">Laâyoune-Sakia El Hamra</option>
    <option value="dakhla-oued-ed-dahab">Dakhla-Oued Ed-Dahab</option>
  </select>
      </div>
  <div id="city-wrapper flex items-center">
    
    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Select City</label>
    <select id="city" class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm">
      <option value="">-- Select a City --</option>
    </select>
  </div>

      </form>

    <script>
      const citiesByRegion = {
      "tanger-tetouan-alhoceima": ["Tanger", "Tétouan", "Al Hoceima", "Chefchaouen", "Larache"],
      "oriental": ["Oujda", "Nador", "Berkane", "Taourirt", "Jerada"],
      "fes-meknes": ["Fès", "Meknès", "Ifrane", "Sefrou", "El Hajeb"],
      "rabat-sale-kenitra": ["Rabat", "Salé", "Kénitra", "Temara", "Skhirat"],
      "beni-mellal-khenifra": ["Béni Mellal", "Khénifra", "Azilal", "Fqih Ben Salah"],
      "casablanca-settat": ["Casablanca", "Settat", "Mohammedia", "El Jadida", "Berrechid"],
      "marrakech-safi": ["Marrakech", "Safi", "Essaouira", "Youssoufia", "Chichaoua"],
      "draa-tafilalet": ["Errachidia", "Ouarzazate", "Tinghir", "Midelt", "Zagora"],
      "souss-massa": ["Agadir", "Inezgane", "Tiznit", "Taroudant", "Tata"],
      "guelmim-oued-noun": ["Guelmim", "Tan-Tan", "Assa-Zag", "Sidi Ifni"],
      "laayoune-sakia-el-hamra": ["Laâyoune", "Boujdour", "Tarfaya", "Es-Semara"],
      "dakhla-oued-ed-dahab": ["Dakhla", "Aousserd"]
    };

    function updateCities() {
      const regionSelect = document.getElementById("region");
      const citySelect = document.getElementById("city");
      const cityWrapper = document.getElementById("city-wrapper");

      const selectedRegion = regionSelect.value;
      citySelect.innerHTML = '<option value="">-- Select a City --</option>';

      if (citiesByRegion[selectedRegion]) {
        citiesByRegion[selectedRegion].forEach(city => {
          const option = document.createElement("option");
          option.value = city.toLowerCase().replace(/\s+/g, '-');
          option.textContent = city;
          citySelect.appendChild(option);
        });
        cityWrapper.style.display = "block";
      } else {
        cityWrapper.style.display = "none";
      }
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  </body>
</html>
