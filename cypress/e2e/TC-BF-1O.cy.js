describe('TC-BF-1O: User mengakses menu produk pada landing page', () => {
  it('should see Produk menu', () => {
    cy.visit('/');
    cy.contains(/Produk/i).should('exist');
    cy.screenshot('TC-BF-1O');
  });
});