const { test, expect } = require('@playwright/test');

test('questionario vai ate o resultado', async ({ page }) => {
  page.on('dialog', (dialog) => dialog.dismiss());

  // DirectoryIndex may serve index.php directly at /
  await page.goto('/index.php');
  await expect(page).toHaveURL(/index\.php/);

  await page.locator('#nomeApelido').fill('Teste Playwright');
  await page.locator('#idade').fill('30');
  await page.locator('#email').fill('teste.playwright@example.com');
  await page.locator('#escolaridade').selectOption(
    'Ensino Superior Completo'
  );
  await page.evaluate(() => {
    const gender = document.getElementById('generoSexual_p');
    if (gender) {
      gender.checked = true;
    }
    const term = document.getElementById('aceitou_termo');
    if (term) {
      term.checked = true;
      term.dispatchEvent(new Event('change', { bubbles: true }));
    }
  });

  // Respostas afirmativas (valor máximo da escala = 2)
  await page.evaluate(() => {
    const names = new Set();
    document
      .querySelectorAll('input[type=radio][name^="questao_"]')
      .forEach((radio) => names.add(radio.name));
    names.forEach((name) => {
      const affirmative = document.querySelector(
        'input[name="' + name + '"][value="2"]'
      );
      if (affirmative) {
        affirmative.checked = true;
      }
    });
  });

  for (let step = 1; step <= 4; step += 1) {
    const next = page.locator('#step-' + step + ' button.next-step');
    if (await next.count()) {
      await next.first().click({ force: true });
      await page.waitForTimeout(300);
    }
  }

  await page.locator('.submitQuestionario').click({ force: true });
  await page.waitForURL(/result\.php/, { timeout: 30000 });
  await expect(page.locator('body')).toContainText(
    /Perfil de Jogador|resultado/i
  );
});
