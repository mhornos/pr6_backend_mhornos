// ajax per carregar models de cotxe des de la api externa a l'hora de inserir o modificar el model del cotxe

document.addEventListener("DOMContentLoaded", () => {
  // selecciona els elements del formulari
  const marcaInput = document.querySelector("#marca");
  const boton = document.querySelector("#btn-models-api");
  const selectModels = document.querySelector("#model_api");
  const status = document.querySelector("#models-api-status");
  const modelInput = document.querySelector("#model");

  // si falta algun element necessari, atura el codi
  if (!marcaInput || !boton || !selectModels || !status) return;

  boton.addEventListener("click", async () => {
    // llegeix la marca escrita per l'usuari
    const marca = marcaInput.value.trim();

    // reinicia el select abans de carregar nous models
    selectModels.innerHTML = '<option value="">Selecciona un model</option>';

    // valida que s'hagi escrit una marca
    if (marca === "") {
      status.textContent = "escriu una marca primer❌";
      return;
    }

    // mostra estat de carrega
    status.textContent = "buscant models...🔄";

    try {
      // construeix la url cap a la teva api pont
      const url = `../api/modelsByMake.php?make=${encodeURIComponent(marca)}`;
      const res = await fetch(url, {
        headers: { "Accept": "application/json" }
      });

      // controla errors http
      if (!res.ok) {
        status.textContent = `error HTTP: ${res.status}`;
        return;
      }

      // converteix la resposta a json
      const json = await res.json();

      // comprova que hi hagi models
      if (!Array.isArray(json.models) || json.models.length === 0) {
        status.textContent = "no s'han trobat models❌";
        return;
      }

      // afegeix cada model com una opcio del select
      json.models.forEach(model => {
        const option = document.createElement("option");
        option.value = model;
        option.textContent = model;
        selectModels.appendChild(option);
      });

      // mostra quants models s'han trobat
      status.textContent = `models trobats: ${json.models.length} ✅`;
    } catch (error) {
      // controla errors de connexio o resposta
      status.textContent = "error consultant l'API externa❌";
    }
  });

  selectModels.addEventListener("change", () => {
    // copia el model seleccionat a l'input principal
    if (modelInput && selectModels.value !== "") {
      modelInput.value = selectModels.value;
    }
  });
});