<?php
include "../db.php";

$categoryCount = $conn->query("SELECT COUNT(*) as total FROM category")->fetch_assoc()['total'];
$userCount = $conn->query("SELECT COUNT(*) as total FROM register")->fetch_assoc()['total'];
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
  }

  .card-stat {
    padding: 25px 20px;
    border-radius: 15px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
    display: flex;
    align-items: center;
    gap: 15px;
  }

  .card-stat:hover {
    transform: translateY(-5px);
  }

  .card-icon {
    font-size: 2rem;
    color: royalblue;
    background: rgba(65, 105, 225, 0.1);
    padding: 15px;
    border-radius: 50%;
  }

  .card-details h5 {
    font-size: 1rem;
    margin: 0;
    color: #888;
  }

  .card-details .number {
    font-size: 1.8rem;
    font-weight: bold;
    color: var(--text-color);
  }
</style>

<div class="stats-grid">
  <div class="card-stat">
    <div class="card-icon"><i class="bi bi-tags"></i></div>
    <div class="card-details">
      <h5>Total Categories</h5>
      <div class="number" data-target="<?= $categoryCount ?>">0</div>
    </div>
  </div>

  <div class="card-stat">
    <div class="card-icon"><i class="bi bi-people"></i></div>
    <div class="card-details">
      <h5>Total Registered Users</h5>
      <div class="number" data-target="<?= $userCount ?>">0</div>
    </div>
  </div>
</div>

<script>
  const counters = document.querySelectorAll('.number');

  counters.forEach(counter => {
    const updateCount = () => {
      const target = +counter.getAttribute('data-target');
      const current = +counter.innerText;
      const increment = Math.ceil(target / 100); 

      if (current < target) {
        counter.innerText = Math.min(current + increment, target);
        setTimeout(updateCount, 15);
      } else {
        counter.innerText = target;
      }
    };
    updateCount();
  });
</script>
