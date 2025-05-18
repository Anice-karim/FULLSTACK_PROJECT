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
//========================Add id Dossier in forms add ordonnace======================
document.addEventListener('DOMContentLoaded', function () {
    const allButtons = document.querySelectorAll('button[data-target][data-id]');

    allButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const target = this.getAttribute('data-target'); // e.g. "#Addordonnance"

            // map modal target to hidden input id
            let inputId;
            switch(target) {
                case '#Addordonnance': inputId = 'ord1_input'; break;
                case '#Acts': inputId = 'acts_input'; break;
                case '#Addimag': inputId = 'imag_input'; break;
                case '#Addactsbri': inputId = 'imag_input'; break;
                case '#Addachats': inputId = 'imag_input'; break;
                case '#Addpara': inputId = 'imag_input'; break;
                default: inputId = 'ord1_input';
            }

            const input = document.getElementById(inputId);
            if(input) {
                input.value = id;
            }
        });
    });
});
//========================Add id Dossier in forms======================