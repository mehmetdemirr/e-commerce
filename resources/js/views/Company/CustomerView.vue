<template>
    <div class="flex h-screen">
      <main class="flex-1 relative">
        <!-- Full screen overlay -->
        <div class="absolute inset-0 bg-blue-500 z-50"></div>
  
        <!-- Main content -->
        <div class=" p-6 text-white">
          <h1 class="text-2xl font-semibold">Main Content</h1>
          <p class="mt-4">This is the main content area. The blue overlay will cover this area.</p>
        </div>
      </main>
    </div>
  </template>
