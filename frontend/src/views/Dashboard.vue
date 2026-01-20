<template>
  <div class="dashboard">
    <div class="dashboard-header">
      <h1>Dashboard</h1>
      <button @click="handleLogout" class="logout-button">Logout</button>
    </div>
    <div class="dashboard-content">
      <p>Selamat datang di Sistem Inventaris Barang!</p>
      <p>User: {{ user?.name }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const user = ref(null)

onMounted(() => {
  const userData = localStorage.getItem('user')
  if (userData) {
    user.value = JSON.parse(userData)
  }
})

const handleLogout = () => {
  localStorage.removeItem('token')
  localStorage.removeItem('user')
  router.push('/login')
}
</script>

<style scoped>
.dashboard {
  min-height: 100vh;
  background: linear-gradient(135deg, #ffffff 0%, #ffffff 100%);
  color: #ffffff;
  padding: 20px;
}

.dashboard-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  background: #242424;
  border-radius: 12px;
  margin-bottom: 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.dashboard-header h1 {
  margin: 0;
  font-size: 28px;
}

.logout-button {
  background: #ffffff;
  color: #000000;
  border: none;
  border-radius: 8px;
  padding: 10px 20px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.logout-button:hover {
  background: #f0f0f0;
  transform: translateY(-2px);
}

.dashboard-content {
  background: #242424;
  border-radius: 12px;
  padding: 30px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.dashboard-content p {
  margin: 10px 0;
  font-size: 16px;
}
</style>
