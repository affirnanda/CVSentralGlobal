describe('TC-BF-1D: Admin menyimpan judul hero section (<=100 karakter)', () => {
  it('Admin menyimpan judul hero section kurang dari sama dengan 100 karakter', () => {
    cy.visit('/login');
    cy.get('input#email').type('super@admin.com');
    cy.get('input#password').type('admin123');
    cy.get('button[type="submit"]').click();
    cy.visit('/admin/kelola-hero-section');
    cy.get('input[name="hero_title"]').clear().type('Solusi Terbaik untuk Bisnis Anda');
    cy.get('textarea[name="section_text"], input[name="section_text"]').clear().type('Deskripsi Hero');
    cy.get('button[type="submit"]').click();
    cy.screenshot('TC-BF-1D');
  });
});