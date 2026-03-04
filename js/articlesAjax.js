
document.addEventListener("DOMContentLoaded", () => {
  const input = document.querySelector("#ajax-q");
  const limitSelect = document.querySelector("#ajax-limit");
  const results = document.querySelector("#ajax-results");
  const status = document.querySelector("#ajax-status");

  if (!input || !results || !status) return;

  let debounceTimer = null;

  async function loadArticles() {
    const q = input.value.trim();
    const limit = limitSelect ? limitSelect.value : "20";

    status.textContent = "Cargando...";
    results.innerHTML = "";

    const url = `../api/articles.php?limit=${encodeURIComponent(limit)}&q=${encodeURIComponent(q)}`;

    try {
      const res = await fetch(url, {
        headers: { "Accept": "application/json" }
      });

      if (!res.ok) {
        status.textContent = `Error HTTP: ${res.status}`;
        return;
      }

      const json = await res.json();

      const data = Array.isArray(json.data) ? json.data : [];
      status.textContent = `Resultados: ${data.length}`;

      if (data.length === 0) {
        results.innerHTML = "<p>No hay resultados.</p>";
        return;
      }

      //render
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
      status.textContent = "Error de red o JSON inválido.";
    }
  }

  function escapeHtml(v) {
    return String(v ?? "")
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  //cargar al entrar
  loadArticles();

  //debounce al escribir
  input.addEventListener("input", () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(loadArticles, 250);
  });

  //si se cambia el limit
  if (limitSelect) {
    limitSelect.addEventListener("change", loadArticles);
  }

  //enter para buscar ya
  input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") loadArticles();
  });
});