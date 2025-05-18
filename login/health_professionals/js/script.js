// ==================== TABLE 1: Medicaments ====================

const tableBody = document.querySelector("#dataTable tbody");

function addNewRow() {
  const rows = tableBody.querySelectorAll("tr");
  if (rows.length > 0) {
    const lastRowInputs = rows[rows.length - 1].querySelectorAll("input");
    const isLastRowEmpty = Array.from(lastRowInputs).every(
      (input) => input.value.trim() === ""
    );
    if (isLastRowEmpty) return;
  }

  const newRow = document.createElement("tr");
  newRow.innerHTML = `
    <td><input class="form-control" type="text" name="item[]"></td>
    <td><input class="form-control" type="number" name="dose[]"></td>
    <td>
      <select class="form-control" name="unite[]">
        <option value="mg">mg</option> 
        <option value="g">g</option> 
        <option value="ml">ml</option> 
      </select>
    </td>
    <td><input class="form-control" type="text" name="recommendation[]"></td>
  `;

  tableBody.appendChild(newRow);
  addInputListenersToRow(newRow, tableBody, addNewRow);
}

function addInputListenersToRow(row, tableBodyRef, addRowFunc) {
  const inputs = row.querySelectorAll("input");

  inputs.forEach((input) => {
    input.addEventListener("input", () => {
      const allRows = tableBodyRef.querySelectorAll("tr");
      if (row === allRows[allRows.length - 1]) {
        const hasValue = Array.from(inputs).some(
          (input) => input.value.trim() !== ""
        );
        if (hasValue) {
          addRowFunc();
        }
      }
    });
  });
}

// ==================== TABLE 2: Imagerie et Analyse ====================

const tableBody1 = document.querySelector("#dataTable1 tbody");

function addNewRow1() {
  const rows = tableBody1.querySelectorAll("tr");
  if (rows.length > 0) {
    const lastRowInputs = rows[rows.length - 1].querySelectorAll("input");
    const isLastRowEmpty = Array.from(lastRowInputs).every(
      (input) => input.value.trim() === ""
    );
    if (isLastRowEmpty) return;
  }

  const newRow = document.createElement("tr");
  newRow.innerHTML = `
    <td><input class="form-control" type="text" name="analyse[]"></td>
    <td><input class="form-control" type="text" name="recommendation_analyse[]"></td>
  `;

  tableBody1.appendChild(newRow);
  addInputListenersToRow(newRow, tableBody1, addNewRow1);
}

// ==================== Init Both Tables on Load ====================

window.addEventListener("DOMContentLoaded", () => {
  addNewRow();
  addNewRow1();
});
