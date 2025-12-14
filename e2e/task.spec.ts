import { test, expect } from '@playwright/test';

test('User can login and create a task', async ({ page }) => {
  await page.goto('/login');

  // 👇 ВИПРАВЛЕННЯ: Шукаємо поля по технічному імені (name="..."), а не по тексту
  await page.locator('input[name="email"]').fill('test@example.com'); 
  await page.locator('input[name="password"]').fill('password');

  // Тиснемо кнопку (тут теж можна підстрахуватися)
  await page.getByRole('button', { name: /log in/i }).click();

  await expect(page).toHaveURL(/.*dashboard/);

  const taskName = `E2E Task ${Date.now()}`;
  
  await page.locator('input[name="title"]').fill(taskName);
  
  // Кнопка створення
  await page.getByRole('button', { name: /Add/i }).click();

  await expect(page.locator('body')).toContainText(taskName);
});