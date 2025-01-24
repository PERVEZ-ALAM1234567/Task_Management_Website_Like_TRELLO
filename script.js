
document.addEventListener("DOMContentLoaded", () => {
  // Fetch tasks from the database on page load
  fetchTasks();

  // Add event listener to the Add Task button
  document.querySelector('.add-task-btn').addEventListener('click', openModal);

  // Add event listener to the close button in the modal
  document.querySelector('.close').addEventListener('click', closeModal);

  // Drag-and-drop event listeners for Kanban columns
  document.querySelectorAll('.kanban-items').forEach(column => {
    column.addEventListener('dragover', e => e.preventDefault());
    column.addEventListener('drop', function () {
      updateTaskStatus(draggedItem.dataset.id, this.id);
      this.appendChild(draggedItem);
    });
  });
});

let draggedItem = null;

// Open the modal
function openModal() {
  document.getElementById('addTaskModal').style.display = 'flex';
}

// Close the modal
function closeModal() {
  document.getElementById('addTaskModal').style.display = 'none';
  document.getElementById('taskForm').reset(); // Reset the form fields
}

// Fetch tasks from the database
async function fetchTasks() {
  try {
    const response = await fetch("fetch_task.php");
    const tasks = await response.json();
    tasks.forEach(task => {
      createTaskElement(task.id, task.title, task.column_name);
    });
  } catch (error) {
    console.error("Error fetching tasks:", error);
  }
}

// Add a new task
async function addTask() {
  const taskTitle = document.getElementById('taskTitle').value.trim();
  const taskColumn = document.getElementById('taskColumn').value;

  if (!taskTitle) {
    alert('Task title is required!');
    return;
  }

  try {
    const response = await fetch("add_task.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ title: taskTitle, column_name: taskColumn }),
    });

    if (!response.ok) throw new Error("Failed to add task");
    const task = await response.json();
    createTaskElement(task.id, task.title, task.column_name); // Create and append the task

    closeModal();
  } catch (error) {
    console.error("Error adding task:", error);
  }
}

// Create a task element
function createTaskElement(id, title, columnName) {
  const taskElement = document.createElement('div');
  taskElement.classList.add('kanban-item');
  taskElement.textContent = title;
  taskElement.setAttribute('draggable', 'true');
  taskElement.dataset.id = id;

  // Add drag-and-drop functionality
  taskElement.addEventListener('dragstart', dragStart);
  taskElement.addEventListener('dragend', dragEnd);

  //----- Delete -------------------------------------------------------
  // Create the delete button
  const deleteButton = document.createElement('button');
  deleteButton.textContent = 'Delete';
  deleteButton.classList.add('delete-btn');
  
  // Add an event listener to handle the task deletion
  deleteButton.addEventListener('click', function () {
    deleteTask(id, taskElement);
  });

  // Append the delete button to the task element
  taskElement.appendChild(deleteButton);
  async function deleteTask(taskId, taskElement) {
    console.log("Delete button clicked for task ID:", taskId);
  
    try {
      const response = await fetch("delete_task.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: taskId }),
      });
  
      const rawResponse = await response.text(); // Log the raw response
      console.log("Raw server response:", rawResponse);
  
      const result = JSON.parse(rawResponse); // Parse the response as JSON
      console.log("Parsed server response:", result);
  
      if (result.success) {
        taskElement.remove();
      } else {
        alert('Error deleting task: ' + result.message);
      }
    } catch (error) {
      console.error("Error deleting task:", error);
    }
  }
  //-----------------------------------------------------

  // Get the correct column where the task should appear
  const column = document.getElementById(`${columnName}-items`);
  if (!column) {
    console.error(`Column with ID "${columnName}-items" not found`);
    return;
  }

  // Always append the new task to the column (bottom position)
  column.appendChild(taskElement);
}

// Drag-and-drop handlers
function dragStart() {
  draggedItem = this;
  setTimeout(() => (this.style.display = 'none'), 0);
}

function dragEnd() {
  setTimeout(() => {
    this.style.display = 'block';
    draggedItem = null;
  }, 0);
}

// Update task status
async function updateTaskStatus(taskId, newColumn) {
  try {
    // Map the column names correctly for the database
    const columnMapping = {
      'todo-items': 'todo',
      'inprogress-items': 'inprogress',
      'done-items': 'done'
    };
    const mappedColumn = columnMapping[newColumn] || 'todo';

    await fetch("update_task.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id: taskId, column_name: mappedColumn }),
    });
  } catch (error) {
    console.error("Error updating task status:", error);
  }
}


// ADD EVENT LISTENER FOR "ENTER" BUTTON------------------------------------------------------------------
document.addEventListener("keydown", (event) => {
if (event.key === "Enter") {
event.preventDefault(); // Prevent default form submission (if any)
addTask(); // Call your function
}
});

// Dynamic Year in Footer-----------------------------------------------------------------------------------------------
document.getElementById('year').textContent = new Date().getFullYear();

//---- TOOGLE MENU CLICKABLE-----------------------------------------------------------------------------------------------------------
function toggleMenu() {
  const navbar = document.querySelector('.navbar');
  navbar.classList.toggle('active');
}