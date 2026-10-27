import { Head, Link, useForm } from '@inertiajs/react';
import { useState } from 'react';
import type { FormEvent } from 'react';
import '../../../css/game-backlog.css';

type Game = {
    id: number;
    title: string;
    platform: string;
    completed: boolean;
};

function GameCard({ game }: { game: Game }) {
    const statusForm = useForm({});

    return (
        <article className="gb-card">
            <span className={game.completed ? 'gb-badge gb-done' : 'gb-badge'}>
                {game.completed ? 'Uitgespeeld' : 'Nog spelen'}
            </span>
            <h3>{game.title}</h3>
            <p>{game.platform}</p>
            <button
                type="button"
                className="gb-secondary"
                disabled={statusForm.processing}
                onClick={() => statusForm.patch(`/games/${game.id}/toggle`, {
                    preserveScroll: true,
                })}
            >
                {game.completed ? 'Zet terug' : 'Markeer als uitgespeeld'}
            </button>
        </article>
    );
}

export default function Index({ games }: { games: Game[] }) {
    const [search, setSearch] = useState('');
    const form = useForm({ title: '', platform: 'PC' });

    // TODO 2: laat alleen games zien waarvan de titel de zoektekst bevat.
    const visibleGames = games;
    // TODO 3: tel alle uitgespeelde games, onafhankelijk van de zoektekst.
    const completedCount = 0;

    function submit(event: FormEvent<HTMLFormElement>) {
        event.preventDefault();
        form.post('/games', {
            preserveScroll: true,
            onSuccess: () => form.reset('title'),
        });
    }

    return (
        <div className="gb-page">
            <Head title="Game Backlog" />
            <Link href="/dashboard" className="gb-back">Terug naar dashboard</Link>
            <header className="gb-header">
                <p className="gb-kicker">MIJN COLLECTIE</p>
                <h1>Game Backlog</h1>
                <p>Bewaar wat je nog wilt spelen.</p>
                <p className="gb-total">{completedCount} van {games.length} uitgespeeld</p>
            </header>
            <section className="gb-panel">
                <h2>Game toevoegen</h2>
                <form onSubmit={submit} noValidate className="gb-form">
                    <div>
                        <label htmlFor="title">Titel</label>
                        <input id="title" value={form.data.title} placeholder="Bijvoorbeeld: Minecraft"
                            onChange={(e) => form.setData('title', e.target.value)}
                            aria-invalid={Boolean(form.errors.title)} aria-describedby="title-error" />
                        <p id="title-error" role="alert" className="gb-error">{form.errors.title}</p>
                    </div>
                    <div>
                        <label htmlFor="platform">Platform</label>
                        <select id="platform" value={form.data.platform}
                            onChange={(e) => form.setData('platform', e.target.value)}>
                            {['PC', 'PlayStation', 'Xbox', 'Switch'].map((platform) => (
                                <option key={platform}>{platform}</option>
                            ))}
                        </select>
                        <p role="alert" className="gb-error">{form.errors.platform}</p>
                    </div>
                    <button className="gb-primary" type="submit" disabled={form.processing}>
                        {form.processing ? 'Opslaan...' : 'Toevoegen'}
                    </button>
                </form>
            </section>
            <section>
                <div className="gb-list-heading">
                    <h2>Mijn games</h2>
                    <label>Zoek op titel
                        <input value={search} placeholder="Zoek een game..."
                            onChange={(e) => setSearch(e.target.value)} />
                    </label>
                </div>
                {games.length === 0 ? (
                    <p className="gb-empty">Je lijst is leeg. Voeg je eerste game toe.</p>
                ) : visibleGames.length === 0 ? (
                    <p className="gb-empty">Geen games gevonden. Probeer een andere zoektekst.</p>
                ) : (
                    <div className="gb-grid">
                        {visibleGames.map((game) => <GameCard key={game.id} game={game} />)}
                    </div>
                )}
            </section>
        </div>
    );
}
