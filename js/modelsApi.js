document.addEventListener("DOMContentLoaded", () => {
  const marcaInput = document.querySelector("#marca");
  const boton = document.querySelector("#btn-models-api");
  const selectModels = document.querySelector("#model_api");
  const status = document.querySelector("#models-api-status");
  const modelInput = document.querySelector("#model");

  if (!marcaInput || !boton || !selectModels || !status) return;

  boton.addEventListener("click", async () => {
    const marca = marcaInput.value.trim();

    selectModels.innerHTML = '<option value="">Selecciona un model</option>';

    if (marca === "") {
      status.textContent = "escriu una marca primer❌\n\n";
      return;
    }

    status.textContent = "buscant models...🔄";

    try {
      const url = `../api/modelsByMake.php?make=${encodeURIComponent(marca)}`;
      const res = await fetch(url, {
        headers: { "Accept": "application/json" }
      });

      if (!res.ok) {
        status.textContent = `error HTTP: ${res.status}`;
        return;
      }

      const json = await res.json();

      if (!Array.isArray(json.models) || json.models.length === 0) {
        status.textContent = "no s'han trobat models❌";
        return;
      }

      json.models.forEach(model => {
        const option = document.createElement("option");
        option.value = model;
        option.textContent = model;
        selectModels.appendChild(option);
      });

      status.textContent = `models trobats: ${json.models.length} ✅`;
    } catch (error) {
      status.textContent = "error consultant l'API externa❌";
    }
  });

  selectModels.addEventListener("change", () => {
    if (modelInput && selectModels.value !== "") {
      modelInput.value = selectModels.value;
    }
  });
});