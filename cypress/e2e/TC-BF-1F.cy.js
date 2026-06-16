describe('TC-BF-1F: Admin menyimpan judul hero section yang kosong', () => {
  it('Admin menyimpan judul hero section kosong', () => {
    cy.visit('/login');
    cy.get('input#email').type('super@admin.com');
    cy.get('input#password').type('admin123');
    cy.get('button[type="submit"]').click();
    cy.visit('/admin/kelola-hero-section');
    cy.get('input[name="hero_title"]').clear();
    cy.get('textarea[name="section_text"], input[name="section_text"]').clear().type('Deskripsi Hero');
    cy.get('button[type="submit"]').click();
    cy.screenshot('TC-BF-1F');
  });
});