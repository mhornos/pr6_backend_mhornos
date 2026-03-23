// ajax per consumir la api propia i mostrar la llista de vehicles

document.addEventListener("DOMContentLoaded", () => {
  // selecciona els elements del html
  const input = document.querySelector("#ajax-q");
  const limitSelect = document.querySelector("#ajax-limit");
  const results = document.querySelector("#ajax-results");
  const status = document.querySelector("#ajax-status");

  // si falta algun element basic, atura el codi
  if (!input || !results || !status) return;

  // variable per controlar el debounce
  let debounceTimer = null;

  async function loadArticles() {
    // llegeix el text de cerca i el limit
    const q = input.value.trim();
    const limit = limitSelect ? limitSelect.value : "20";

    // mostra estat de carrega i neteja resultats
    status.textContent = "carregant...🔄";
    results.innerHTML = "";

    // construeix la url de la peticio
    const url = `../api/articles.php?limit=${encodeURIComponent(limit)}&q=${encodeURIComponent(q)}`;

    try {
      // fa la peticio a l'api
      const res = await fetch(url, {
        headers: { "Accept": "application/json" }
      });

      // controla errors http
      if (!res.ok) {
        status.textContent = `error HTTP: ${res.status}❌`;
        return;
      }

      // converteix la resposta a json
      const json = await res.json();

      // assegura que data sigui un array
      const data = Array.isArray(json.data) ? json.data : [];
      status.textContent = `resultats: ${data.length}`;

      // si no hi ha resultats, ho mostra
      if (data.length === 0) {
        results.innerHTML = "<p>no hi ha resultats</p>";
        return;
      }

      // genera les files de la taula i printa la taula
      const rowsHtml = data.map(a => `
        <tr>
          <td>${escapeHtml(a.ID)}</td>
          <td>${escapeHtml(a.marca)}</td>
          <td>${escapeHtml(a.model)}</td>
          <td>${escapeHtml(a.any)}</td>
          <td>${escapeHtml(a.color)}</td>
          <td>${escapeHtml(a.matricula)}</td>
          <td>${escapeHtml(a.nom_usuari ?? "")}</td>
        </tr>
      `).join("");

      results.innerHTML = `
        <table class="taula">
          <thead>
            <tr>
              <th>ID</th>
              <th>Marca</th>
              <th>Model</th>
              <th>Any</th>
              <th>Color</th>
              <th>Matrícula</th>
              <th>Usuari</th>
            </tr>
          </thead>
          <tbody>
            ${rowsHtml}
          </tbody>
        </table>
      `;
    } catch (e) {
      status.textContent = "error de red o JSON invalid";
    }
  }

  function escapeHtml(v) {
    // evita injectar html al mostrar dades
    return String(v ?? "")
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  // carrega dades en entrar a la pagina
  loadArticles();

  // espera una mica abans de buscar mentre s'escriu
  input.addEventListener("input", () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(loadArticles, 250);
  });

  // torna a carregar si canvia el limit
  if (limitSelect) {
    limitSelect.addEventListener("change", loadArticles);
  }

  // evita que enter reinicii el formulari
  input.addEventListener("keydown", (e) => {
  if (e.key === "Enter") {
    e.preventDefault();
  }
});
});