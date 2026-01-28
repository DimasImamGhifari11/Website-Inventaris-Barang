<template>
  <div class="login-container">
    <!-- Notifikasi Pop-up -->
    <Transition name="notification">
      <div v-if="showNotification" class="notification">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
          <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <span>Login berhasil</span>
      </div>
    </Transition>

    <div class="login-box">
      <div class="login-header">
        <h1>Inventaris Barang</h1>
        <p>Dinas Komunikasi Informatika dan Persandian Hulu Sungai Utara</p>
      </div>

      <form @submit.prevent="handleLogin" class="login-form">
        <div class="form-group">
          <input
            id="username"
            v-model="form.username"
            type="text"
            placeholder="Username"
            required
            autocomplete="username"
          />
        </div>

        <div class="form-group password-group">
          <input
            id="password"
            v-model="form.password"
            :type="showPassword ? 'text' : 'password'"
            placeholder="Password"
            required
            autocomplete="current-password"
          />
          <button
            type="button"
            class="toggle-password"
            @click="showPassword = !showPassword"
          >
            <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
              <line x1="1" y1="1" x2="23" y2="23"></line>
            </svg>
          </button>
        </div>

        <div v-if="errorMessage" class="error-message">
          {{ errorMessage }}
        </div>

        <button type="submit" class="login-button" :disabled="loading">
          <span v-if="loading">Memuat...</span>
          <span v-else>Login</span>
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../api'

const router = useRouter()

const form = ref({
  username: '',
  password: ''
})

const loading = ref(false)
const errorMessage = ref('')
const showPassword = ref(false)
const showNotification = ref(false)

const handleLogin = async () => {
  loading.value = true
  errorMessage.value = ''

  try {
    const response = await api.post('/login', {
      username: form.value.username,
      password: form.value.password
    })

    if (response.data.success) {
      sessionStorage.setItem('token', response.data.token)
      sessionStorage.setItem('user', JSON.stringify(response.data.user))

      // Tampilkan notifikasi
      showNotification.value = true

      // Redirect setelah 1.5 detik
      setTimeout(() => {
        router.push('/dashboard')
      }, 1500)
    }
  } catch (error) {
    if (error.response && error.response.data) {
      errorMessage.value = error.response.data.message || 'Login gagal. Periksa username dan password Anda.'
    } else {
      errorMessage.value = 'Terjadi kesalahan. Silakan coba lagi.'
    }
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.login-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--bg-primary);
  padding: 20px;
  position: relative;
  transition: background 0.3s ease;
}

/* Notifikasi */
.notification {
  position: fixed;
  top: 32px;
  left: 50%;
  transform: translateX(-50%);
  background: var(--bg-card);
  border: 1px solid var(--border-color);
  border-radius: 10px;
  padding: 14px 24px;
  display: flex;
  align-items: center;
  gap: 10px;
  color: var(--text-primary);
  font-size: 14px;
  font-weight: 500;
  z-index: 1000;
  transition: background 0.3s ease, border-color 0.3s ease;
}

.notification svg {
  color: #34c759;
}

/* Animasi notifikasi */
.notification-enter-active {
  animation: slideDown 0.4s ease-out;
}

.notification-leave-active {
  animation: slideUp 0.3s ease-in;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateX(-50%) translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }
}

@keyframes slideUp {
  from {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }
  to {
    opacity: 0;
    transform: translateX(-50%) translateY(-20px);
  }
}

.login-box {
  background: var(--bg-card);
  border-radius: 12px;
  width: 100%;
  max-width: 360px;
  padding: 40px 36px;
  border: 1px solid var(--border-color);
  transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease, border-color 0.3s ease;
}

.login-box:hover {
  transform: translateY(-0.9px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

.login-header {
  text-align: center;
  margin-bottom: 28px;
}

.login-header h1 {
  color: var(--text-primary);
  font-size: 24px;
  font-weight: 700;
  margin: 0 0 6px 0;
  letter-spacing: -0.5px;
}

.login-header p {
  color: var(--text-secondary);
  font-size: 14px;
  margin: 0;
  font-weight: 400;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.password-group {
  position: relative;
}

.password-group input {
  padding-right: 44px;
}

.toggle-password {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  padding: 4px;
  cursor: pointer;
  color: var(--text-secondary);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: color 0.2s ease;
}

.toggle-password:hover {
  color: var(--text-primary);
}

.form-group input {
  background: var(--bg-input);
  border: 1px solid var(--border-color);
  border-radius: 8px;
  padding: 12px 14px;
  color: var(--text-primary);
  font-size: 14px;
  font-weight: 400;
  transition: all 0.2s ease;
  outline: none;
  width: 100%;
}

.form-group input::placeholder {
  color: var(--text-secondary);
}

.form-group input:hover {
  border-color: var(--text-secondary);
}

.form-group input:focus {
  border-color: #0071e3;
  background: var(--bg-card);
}

.error-message {
  background: #fff5f5;
  border: 1px solid #fed7d7;
  color: #c53030;
  padding: 10px 14px;
  border-radius: 8px;
  font-size: 13px;
  text-align: center;
}

.login-button {
  background: var(--text-primary);
  color: var(--bg-primary);
  border: none;
  border-radius: 8px;
  padding: 12px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s ease;
  margin-top: 8px;
}

.login-button:hover:not(:disabled) {
  background: #333336;
}

.login-button:active:not(:disabled) {
  transform: scale(0.98);
}

.login-button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Tablet */
@media (max-width: 768px) {
  .login-container {
    padding: 16px;
  }

  .notification {
    top: 16px;
    left: 16px;
    right: 16px;
    transform: none;
    justify-content: center;
  }

  .notification-enter-active {
    animation: slideDownMobile 0.4s ease-out;
  }

  .notification-leave-active {
    animation: slideUpMobile 0.3s ease-in;
  }

  @keyframes slideDownMobile {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes slideUpMobile {
    from {
      opacity: 1;
      transform: translateY(0);
    }
    to {
      opacity: 0;
      transform: translateY(-20px);
    }
  }
}

/* Mobile */
@media (max-width: 480px) {
  .login-box {
    padding: 32px 24px;
  }

  .login-header h1 {
    font-size: 20px;
  }

  .login-header p {
    font-size: 13px;
  }

  .form-group input {
    padding: 14px;
    font-size: 16px; /* Prevent zoom on iOS */
  }

  .login-button {
    padding: 14px;
  }
}
</style>
