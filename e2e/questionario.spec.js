const { test, expect } = require('@playwright/test');

test('questionario vai ate o resultado', async ({ page }) => {
  page.on('dialog', (dialog) => dialog.dismiss());

  await page.goto('/');
  await page.getByRole('link', { name: /Faça o teste/i }).click();
  await expect(page).toHaveURL(/index\.php/);

  await page.locator('#nomeApelido').fill('Teste Playwright');
  await page.locator('#idade').fill('30');
  await page.locator('#email').fill('teste.playwright@example.com');
  await page.locator('#escolaridade').selectOption(
    'Ensino Superior Completo'
  );
  await page.locator('#generoSexual_p').check();
  await page.locator('#aceitou_termo').check();

  await page.evaluate(() => {
    const names = new Set();
    document
      .querySelectorAll('input[type=radio][name^="questao_"]')
      .forEach((radio) => names.add(radio.name));
    names.forEach((name) => {
      const mid = document.querySelector(
        'input[name="' + name + '"][value="0"]'
      );
      const first = document.querySelector(
        'input[name="' + name + '"]'
      );
      const target = mid || first;
      if (target) {
        target.checked = true;
      }
    });
  });

  await page.locator('#step-1 button.next-step').click();

  for (let i = 0; i < 5; i += 1) {
    const next = page.locator('button.next-step:visible');
    if (await next.count() === 0) {
      break;
    }
    await next.last().click();
    await page.waitForTimeout(300);
  }

  await page.locator('.submitQuestionario').click();
  await page.waitForURL(/resultado\.php/, { timeout: 30000 });
  await expect(page.locator('body')).toContainText(
    /Perfil de Jogador|resultado/i
  );
});
