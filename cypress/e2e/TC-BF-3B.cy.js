describe('TC-BF-3B: Admin mengakses dashboard dengan session kadaluarsa', () => {

    it('Pengguna tanpa session diarahkan ke halaman login', () => {

     
        cy.clearCookies()
        cy.clearLocalStorage()

        cy.visit('http://127.0.0.1:8000/dashboard')

  
        cy.url().should('include', '/login')

        cy.get('input#email').should('be.visible')
        cy.get('input#password').should('be.visible')

        cy.screenshot('TC-BF-3B -- Admin mengakses dashboard dengan session kadaluarsa')
    })

})
