const { useState, useEffect } = React;

function App() {
    // Stav pro uchování informací o přihlášeném uživateli
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);
    const [view, setView] = useState('login'); 

    // Při načtení ověříme session v PHP
    useEffect(() => {
        fetch('index.php?action=check_auth')
            .then(res => res.json())
            .then(data => {
                if (data.logged_in) {
                    setUser(data.username);
                }
                setLoading(false);
            })
            .catch(() => setLoading(false));
    }, []);

    // Odhlášení zruší session v PHP i stav v Reactu
    const handleLogout = () => {
        fetch('index.php?action=logout')
            .then(res => res.json())
            .then(() => {
                setUser(null);
                setView('login');
            });
    };

    // Zatímco čekáme na ověření session, zobrazíme načítací spinner
    if (loading) {
        return (
            <div className="d-flex justify-content-center align-items-center vh-100">
                <div className="spinner-border text-primary" role="status">
                    <span className="visually-hidden">Načítání...</span>
                </div>
            </div>
        );
    }

    // Pokud uživatel není přihlášen, zobrazíme buď přihlašovací nebo registrační formulář
    if (!user) {
        return view === 'login' ? (
            <LoginForm 
                onLoginSuccess={(username) => setUser(username)} 
                onSwitchToRegister={() => setView('register')} 
            />
        ) : (
            <RegisterForm 
                onSwitchToLogin={() => setView('login')} 
            />
        );
    }



    // Pokud je uživatel přihlášen, zobrazíme hlavní obsah aplikace
    return (
        <div>
            <Header user={user} onLogout={handleLogout} />
            <div className="container">
                <div className="card shadow-sm p-4">
                    <h5 className="card-title">Přihlášení úspěšné!</h5>
                    <p className="text-muted">Jsi přihlášen jako <strong>{user}</strong>. TODO: Přidat obsah aplikace </p>
                </div>
            </div>
        </div>
    );
}

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(<App />);