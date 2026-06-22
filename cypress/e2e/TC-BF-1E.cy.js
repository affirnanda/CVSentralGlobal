describe('TC-BF-1E: Admin menyimpan judul hero section (>100 karakter)', () => {
  it('Admin menyimpan judul hero section lebih dari 100 karakter', () => {
    cy.visit('/login');
    cy.get('input#email').type('super@admin.com');
    cy.get('input#password').type('admin123');
    cy.get('button[type="submit"]').click({force: true});
    cy.visit('/admin/kelola-hero-section');
    cy.get('input[name="hero_title"]').clear({force: true}).type('A'.repeat(101));
    cy.get('textarea[name="section_text"], input[name="section_text"]').clear({force: true}).type('Deskripsi Hero', {force: true});
    cy.get('button[type="submit"]').click({force: true});
    cy.screenshot('TC-BF-1E');
  });
});